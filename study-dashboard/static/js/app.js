/**
 * Study Dashboard - Main Application
 * Handles JSON loading, search, progress tracking, bookmarks, and navigation
 */

// ========== State Management ==========
const State = {
  allQuestions: [],
  filteredQuestions: [],
  files: [],
  stats: {},
  currentView: 'dashboard',
  currentPage: 1,
  itemsPerPage: 20,
  searchQuery: '',
  difficultyFilter: 'all',
  topicFilter: null,
  completed: new Set(),
  bookmarks: new Set(),
};

// ========== Local Storage ==========
const Storage = {
  KEYS: { completed: 'study_completed', bookmarks: 'study_bookmarks' },
  load() {
    try {
      const c = localStorage.getItem(this.KEYS.completed);
      const b = localStorage.getItem(this.KEYS.bookmarks);
      if (c) State.completed = new Set(JSON.parse(c));
      if (b) State.bookmarks = new Set(JSON.parse(b));
    } catch (e) { console.warn('Storage load error:', e); }
  },
  save() {
    try {
      localStorage.setItem(this.KEYS.completed, JSON.stringify([...State.completed]));
      localStorage.setItem(this.KEYS.bookmarks, JSON.stringify([...State.bookmarks]));
    } catch (e) { console.warn('Storage save error:', e); }
  },
  reset() {
    State.completed.clear();
    State.bookmarks.clear();
    this.save();
  }
};


// ========== API Functions ==========
const API = {
  async fetchAll() {
    const res = await fetch('/api/all');
    return res.json();
  },
  async fetchFiles() {
    const res = await fetch('/api/files');
    return res.json();
  },
  async fetchStats() {
    const res = await fetch('/api/stats');
    return res.json();
  }
};

// ========== Utility Functions ==========
function getQuestionKey(q) {
  return `${q._source_file || 'unknown'}_${q.id}`;
}

function escapeHtml(str) {
  if (!str) return '';
  return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function highlightText(text, query) {
  if (!query || !text) return escapeHtml(text);
  const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  const regex = new RegExp(`(${escaped})`, 'gi');
  return escapeHtml(text).replace(regex, '<mark>$1</mark>');
}

function showToast(message, type = 'info') {
  const container = document.getElementById('toast-container');
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  toast.innerHTML = `<span>${message}</span>`;
  container.appendChild(toast);
  setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
}

function formatFileSize(bytes) {
  if (bytes < 1024) return bytes + ' B';
  if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
  return (bytes / 1048576).toFixed(1) + ' MB';
}


// ========== Navigation ==========
function switchView(viewName) {
  State.currentView = viewName;
  State.currentPage = 1;
  document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
  document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
  const view = document.getElementById(`view-${viewName}`);
  if (view) view.classList.add('active');
  const btn = document.querySelector(`.nav-btn[data-view="${viewName}"]`);
  if (btn) btn.classList.add('active');
  renderCurrentView();
}

function renderCurrentView() {
  switch (State.currentView) {
    case 'dashboard': renderDashboard(); break;
    case 'topics': renderTopics(); break;
    case 'questions': renderQuestions(); break;
    case 'bookmarks': renderBookmarks(); break;
    case 'files': renderFiles(); break;
  }
}

// ========== Dashboard View ==========
function renderDashboard() {
  const total = State.allQuestions.length;
  const completed = State.completed.size;
  const topics = new Set(State.allQuestions.map(q => q.topic)).size;
  const bookmarks = State.bookmarks.size;

  document.getElementById('dash-total').textContent = total;
  document.getElementById('dash-completed').textContent = completed;
  document.getElementById('dash-topics').textContent = topics;
  document.getElementById('dash-bookmarks').textContent = bookmarks;

  // Difficulty breakdown
  const diffs = { Easy: 0, Medium: 0, Hard: 0 };
  State.allQuestions.forEach(q => { if (diffs[q.difficulty] !== undefined) diffs[q.difficulty]++; });
  const maxDiff = Math.max(...Object.values(diffs), 1);

  document.getElementById('diff-easy-bar').style.width = `${(diffs.Easy/maxDiff)*100}%`;
  document.getElementById('diff-medium-bar').style.width = `${(diffs.Medium/maxDiff)*100}%`;
  document.getElementById('diff-hard-bar').style.width = `${(diffs.Hard/maxDiff)*100}%`;
  document.getElementById('diff-easy-count').textContent = diffs.Easy;
  document.getElementById('diff-medium-count').textContent = diffs.Medium;
  document.getElementById('diff-hard-count').textContent = diffs.Hard;

  // Topics progress
  renderTopicsProgress();
}


function renderTopicsProgress() {
  const grid = document.getElementById('topics-progress-grid');
  const topicMap = {};
  State.allQuestions.forEach(q => {
    const t = q.topic || 'Unknown';
    if (!topicMap[t]) topicMap[t] = { total: 0, completed: 0 };
    topicMap[t].total++;
    if (State.completed.has(getQuestionKey(q))) topicMap[t].completed++;
  });

  const sorted = Object.entries(topicMap).sort((a, b) => b[1].total - a[1].total);
  grid.innerHTML = sorted.map(([topic, data]) => {
    const pct = data.total > 0 ? Math.round((data.completed / data.total) * 100) : 0;
    return `
      <div class="topic-progress-item" onclick="filterByTopic('${escapeHtml(topic)}')">
        <div class="topic-progress-header">
          <span class="topic-progress-name" title="${escapeHtml(topic)}">${escapeHtml(topic)}</span>
          <span class="topic-progress-pct">${pct}%</span>
        </div>
        <div class="topic-progress-bar"><div class="topic-progress-fill" style="width:${pct}%"></div></div>
      </div>`;
  }).join('');
}

// ========== Topics View ==========
function renderTopics() {
  const grid = document.getElementById('topics-grid');
  const topicMap = {};
  State.allQuestions.forEach(q => {
    const t = q.topic || 'Unknown';
    if (!topicMap[t]) topicMap[t] = { total: 0, completed: 0, easy: 0, medium: 0, hard: 0 };
    topicMap[t].total++;
    if (q.difficulty === 'Easy') topicMap[t].easy++;
    if (q.difficulty === 'Medium') topicMap[t].medium++;
    if (q.difficulty === 'Hard') topicMap[t].hard++;
    if (State.completed.has(getQuestionKey(q))) topicMap[t].completed++;
  });

  const sorted = Object.entries(topicMap).sort((a, b) => b[1].total - a[1].total);
  grid.innerHTML = sorted.map(([topic, data]) => {
    const pct = data.total > 0 ? Math.round((data.completed / data.total) * 100) : 0;
    return `
      <div class="topic-card" onclick="filterByTopic('${escapeHtml(topic)}')">
        <div class="topic-card-title">${escapeHtml(topic)}</div>
        <div class="topic-card-stats">
          <span>📝 ${data.total} Qs</span>
          <span>🟢${data.easy} 🟡${data.medium} 🔴${data.hard}</span>
        </div>
        <div class="topic-card-progress">
          <div class="progress-bar-container">
            <div class="progress-bar" style="width:${pct}%"></div>
          </div>
          <p class="progress-text">${data.completed}/${data.total} done (${pct}%)</p>
        </div>
      </div>`;
  }).join('');
}

function filterByTopic(topic) {
  State.topicFilter = topic;
  State.currentPage = 1;
  switchView('questions');
  document.getElementById('questions-subtitle').textContent = `Topic: ${topic}`;
  applyFilters();
  renderQuestions();
}


// ========== Questions View ==========
function applyFilters() {
  let qs = [...State.allQuestions];
  if (State.topicFilter) {
    qs = qs.filter(q => q.topic === State.topicFilter);
  }
  if (State.difficultyFilter !== 'all') {
    qs = qs.filter(q => q.difficulty === State.difficultyFilter);
  }
  if (State.searchQuery) {
    const query = State.searchQuery.toLowerCase();
    qs = qs.filter(q =>
      (q.question && q.question.toLowerCase().includes(query)) ||
      (q.topic && q.topic.toLowerCase().includes(query)) ||
      (q.hinglish_explanation && q.hinglish_explanation.toLowerCase().includes(query)) ||
      (q.how_to_answer && q.how_to_answer.toLowerCase().includes(query)) ||
      (q.real_life_example && q.real_life_example.toLowerCase().includes(query))
    );
  }
  State.filteredQuestions = qs;
}

function renderQuestions() {
  applyFilters();
  const list = document.getElementById('questions-list');
  const total = State.filteredQuestions.length;
  const start = (State.currentPage - 1) * State.itemsPerPage;
  const end = Math.min(start + State.itemsPerPage, total);
  const pageItems = State.filteredQuestions.slice(start, end);

  if (!State.topicFilter && !State.searchQuery) {
    document.getElementById('questions-subtitle').textContent = `${total} questions`;
  } else if (State.searchQuery) {
    document.getElementById('questions-subtitle').textContent = `${total} results for "${State.searchQuery}"`;
  }

  if (pageItems.length === 0) {
    list.innerHTML = `<div class="empty-state"><div class="empty-state-icon">🔍</div><p class="empty-state-text">No questions found</p></div>`;
    document.getElementById('pagination').innerHTML = '';
    return;
  }

  list.innerHTML = pageItems.map(q => renderQuestionCard(q)).join('');
  renderPagination(total);
}

function renderQuestionCard(q) {
  const key = getQuestionKey(q);
  const isCompleted = State.completed.has(key);
  const isBookmarked = State.bookmarks.has(key);
  const diffClass = (q.difficulty || '').toLowerCase();
  const query = State.searchQuery;

  return `
    <div class="question-card ${isCompleted ? 'completed' : ''}" onclick="openQuestionModal('${key}')">
      <div class="question-card-header">
        <div class="question-card-title">${highlightText(q.question, query)}</div>
        <div class="question-card-actions">
          <button class="${isBookmarked ? 'active' : ''}" onclick="event.stopPropagation(); toggleBookmark('${key}')" title="Bookmark">⭐</button>
          <button class="${isCompleted ? 'active' : ''}" onclick="event.stopPropagation(); toggleComplete('${key}')" title="Mark Complete" style="${isCompleted ? 'background:var(--accent-green);color:#000' : ''}">✓</button>
        </div>
      </div>
      <div class="question-card-meta">
        <span class="meta-tag ${diffClass}">${q.difficulty || 'N/A'}</span>
        <span class="meta-tag topic">${escapeHtml(q.topic || '')}</span>
        <span class="meta-tag file">${escapeHtml(q._source_file || '')}</span>
      </div>
    </div>`;
}


function renderPagination(total) {
  const pages = Math.ceil(total / State.itemsPerPage);
  if (pages <= 1) { document.getElementById('pagination').innerHTML = ''; return; }
  let html = '';
  const maxVisible = 7;
  let startPage = Math.max(1, State.currentPage - 3);
  let endPage = Math.min(pages, startPage + maxVisible - 1);
  if (endPage - startPage < maxVisible - 1) startPage = Math.max(1, endPage - maxVisible + 1);

  if (State.currentPage > 1) html += `<button class="page-btn" onclick="goToPage(${State.currentPage-1})">‹</button>`;
  for (let i = startPage; i <= endPage; i++) {
    html += `<button class="page-btn ${i === State.currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>`;
  }
  if (State.currentPage < pages) html += `<button class="page-btn" onclick="goToPage(${State.currentPage+1})">›</button>`;
  document.getElementById('pagination').innerHTML = html;
}

function goToPage(page) {
  State.currentPage = page;
  renderQuestions();
  document.querySelector('.content-area').scrollTop = 0;
}

// ========== Bookmarks View ==========
function renderBookmarks() {
  const list = document.getElementById('bookmarks-list');
  const bookmarked = State.allQuestions.filter(q => State.bookmarks.has(getQuestionKey(q)));
  if (bookmarked.length === 0) {
    list.innerHTML = `<div class="empty-state"><div class="empty-state-icon">⭐</div><p class="empty-state-text">No bookmarked questions yet.<br>Click the star icon on any question to bookmark it.</p></div>`;
    return;
  }
  list.innerHTML = bookmarked.map(q => renderQuestionCard(q)).join('');
}

// ========== Files View ==========
function renderFiles() {
  const list = document.getElementById('files-list');
  if (State.files.length === 0) {
    list.innerHTML = `<div class="empty-state"><div class="empty-state-icon">📄</div><p class="empty-state-text">No JSON files found in ./data/ folder</p></div>`;
    return;
  }
  list.innerHTML = State.files.map(f => `
    <div class="file-card">
      <div class="file-card-name">📄 ${escapeHtml(f.name)}</div>
      <div class="file-card-info">
        <span>📝 ${f.questions} questions</span>
        <span>💾 ${formatFileSize(f.size)}</span>
        <span>📂 ${f.topics.length} topic(s)</span>
        ${f.topics.length > 0 ? `<span style="font-size:0.75rem;color:var(--text-muted);margin-top:4px">${f.topics.slice(0,5).join(', ')}${f.topics.length > 5 ? '...' : ''}</span>` : ''}
      </div>
    </div>
  `).join('');
}


// ========== Question Modal ==========
function openQuestionModal(key) {
  const q = State.allQuestions.find(item => getQuestionKey(item) === key);
  if (!q) return;
  const modal = document.getElementById('question-modal');
  const body = document.getElementById('modal-body');
  const isCompleted = State.completed.has(key);
  const isBookmarked = State.bookmarks.has(key);

  body.innerHTML = `
    <h2>${escapeHtml(q.question)}</h2>
    <div class="question-card-meta" style="margin-bottom:20px">
      <span class="meta-tag ${(q.difficulty||'').toLowerCase()}">${q.difficulty || 'N/A'}</span>
      <span class="meta-tag topic">${escapeHtml(q.topic || '')}</span>
      <span class="meta-tag file">${escapeHtml(q._source_file || '')}</span>
    </div>
    ${q.diagram ? `<div class="modal-section"><div class="modal-section-title">📊 Diagram</div><pre class="modal-diagram">${escapeHtml(q.diagram)}</pre></div>` : ''}
    ${q.hinglish_explanation ? `<div class="modal-section"><div class="modal-section-title">💬 Hinglish Explanation</div><div class="modal-section-content">${escapeHtml(q.hinglish_explanation)}</div></div>` : ''}
    ${q.real_life_example ? `<div class="modal-section"><div class="modal-section-title">🎯 Real Life Example</div><div class="modal-section-content">${escapeHtml(q.real_life_example)}</div></div>` : ''}
    ${q.how_to_answer ? `<div class="modal-section"><div class="modal-section-title">🎤 How to Answer in Interview</div><div class="modal-section-content">${escapeHtml(q.how_to_answer)}</div></div>` : ''}
    <div class="modal-actions">
      <button class="modal-btn modal-btn-complete ${isCompleted ? 'done' : ''}" onclick="toggleComplete('${key}'); openQuestionModal('${key}')">
        ${isCompleted ? '↩️ Mark Incomplete' : '✅ Mark Complete'}
      </button>
      <button class="modal-btn modal-btn-bookmark" onclick="toggleBookmark('${key}'); openQuestionModal('${key}')">
        ${isBookmarked ? '★ Unbookmark' : '☆ Bookmark'}
      </button>
    </div>
  `;
  modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('question-modal').classList.add('hidden');
  document.body.style.overflow = '';
}

// ========== Toggle Actions ==========
function toggleComplete(key) {
  if (State.completed.has(key)) {
    State.completed.delete(key);
    showToast('Marked as incomplete', 'info');
  } else {
    State.completed.add(key);
    showToast('Marked as complete! ✅', 'success');
  }
  Storage.save();
  updateSidebarStats();
  renderCurrentView();
}

function toggleBookmark(key) {
  if (State.bookmarks.has(key)) {
    State.bookmarks.delete(key);
    showToast('Bookmark removed', 'info');
  } else {
    State.bookmarks.add(key);
    showToast('Bookmarked! ⭐', 'success');
  }
  Storage.save();
  updateBookmarkCount();
  renderCurrentView();
}


// ========== Sidebar Stats ==========
function updateSidebarStats() {
  const total = State.allQuestions.length;
  const completed = State.completed.size;
  const topics = new Set(State.allQuestions.map(q => q.topic)).size;
  const pct = total > 0 ? Math.round((completed / total) * 100) : 0;

  document.getElementById('stat-total').textContent = total;
  document.getElementById('stat-topics').textContent = topics;
  document.getElementById('stat-files').textContent = State.files.length;
  document.getElementById('overall-progress-bar').style.width = `${pct}%`;
  document.getElementById('overall-progress-text').textContent = `${completed} / ${total} completed (${pct}%)`;
}

function updateBookmarkCount() {
  document.getElementById('bookmark-count').textContent = State.bookmarks.size;
}

// ========== Search ==========
let searchTimeout;
function handleSearch(value) {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    State.searchQuery = value.trim();
    State.currentPage = 1;
    const clearBtn = document.getElementById('search-clear');
    if (value) clearBtn.classList.remove('hidden');
    else clearBtn.classList.add('hidden');

    if (State.currentView !== 'questions' && value) {
      State.topicFilter = null;
      switchView('questions');
    } else {
      renderCurrentView();
    }
  }, 250);
}

function clearSearch() {
  document.getElementById('search-input').value = '';
  State.searchQuery = '';
  State.topicFilter = null;
  document.getElementById('search-clear').classList.add('hidden');
  document.getElementById('questions-subtitle').textContent = `${State.allQuestions.length} questions`;
  renderCurrentView();
}

// ========== Reset Progress ==========
function resetProgress() {
  if (confirm('Are you sure you want to reset ALL progress? This cannot be undone.')) {
    Storage.reset();
    updateSidebarStats();
    updateBookmarkCount();
    renderCurrentView();
    showToast('All progress reset', 'warning');
  }
}


// ========== Event Listeners ==========
function setupEventListeners() {
  // Navigation
  document.querySelectorAll('.nav-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      State.topicFilter = null;
      State.searchQuery = '';
      document.getElementById('search-input').value = '';
      document.getElementById('search-clear').classList.add('hidden');
      switchView(btn.dataset.view);
    });
  });

  // Sidebar toggle
  document.getElementById('sidebar-toggle').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('collapsed');
  });

  // Search
  document.getElementById('search-input').addEventListener('input', (e) => handleSearch(e.target.value));
  document.getElementById('search-clear').addEventListener('click', clearSearch);

  // Keyboard shortcut: Ctrl+K for search
  document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
      e.preventDefault();
      document.getElementById('search-input').focus();
    }
    if (e.key === 'Escape') {
      closeModal();
    }
  });

  // Difficulty filter
  document.getElementById('difficulty-filter').addEventListener('change', (e) => {
    State.difficultyFilter = e.target.value;
    State.currentPage = 1;
    if (State.currentView === 'questions') renderQuestions();
  });

  // Reset button
  document.getElementById('reset-progress-btn').addEventListener('click', resetProgress);

  // Modal close
  document.getElementById('modal-close').addEventListener('click', closeModal);
  document.querySelector('.modal-overlay').addEventListener('click', closeModal);
}

// ========== Initialization ==========
async function init() {
  try {
    Storage.load();

    // Fetch data from server
    const [allData, files] = await Promise.all([
      API.fetchAll(),
      API.fetchFiles()
    ]);

    State.allQuestions = allData;
    State.files = files;
    State.filteredQuestions = [...allData];

    // Setup UI
    setupEventListeners();
    updateSidebarStats();
    updateBookmarkCount();
    renderDashboard();

    // Hide loading, show app
    document.getElementById('loading-screen').classList.add('hidden');
    document.getElementById('app').classList.remove('hidden');

    console.log(`📚 Study Dashboard loaded: ${allData.length} questions from ${files.length} files`);
  } catch (error) {
    console.error('Failed to initialize:', error);
    document.querySelector('.loader p').textContent = 'Error loading data. Is the server running?';
    document.querySelector('.loader-ring').style.borderTopColor = '#ef4444';
  }
}

// Start app when DOM ready
document.addEventListener('DOMContentLoaded', init);
