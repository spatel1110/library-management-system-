# 📚 Study Dashboard

A modern, dark-themed local web application that reads JSON study files and displays them in an organized, interactive dashboard with search, progress tracking, and bookmarks.

## 🚀 Quick Start

```bash
# 1. Navigate to the study-dashboard folder
cd study-dashboard

# 2. Place your JSON files in the data/ folder
# (Already includes sample question files)

# 3. Start the server
python server.py

# 4. Open in browser
# http://localhost:8080
```

## ✨ Features

- **📊 Dashboard Overview** — Stats cards, difficulty breakdown, topic progress
- **📂 Topic Browser** — Group questions by topic, see per-topic progress
- **🔍 Powerful Search** — Instant search across all questions (Ctrl+K shortcut)
- **✅ Progress Tracking** — Mark questions as completed, saves to localStorage
- **⭐ Bookmarks** — Save important questions for quick review
- **🌙 Dark Theme** — Modern dark UI with smooth animations
- **📄 File Manager** — View loaded JSON files and their stats
- **🔒 100% Local** — No internet required, data stays on your machine

## 📁 Project Structure

```
study-dashboard/
├── server.py              # Python HTTP server with API endpoints
├── index.html             # Main HTML page
├── static/
│   ├── css/style.css      # Dark theme styles
│   └── js/app.js          # Application logic
├── data/                  # Place JSON files here
│   ├── aws_ml_interview_questions.json
│   └── llm_agentic_ai_interview_questions.json
└── README.md
```

## 📄 JSON Format

The dashboard expects JSON files with arrays of objects. Best format:

```json
[
  {
    "id": 1,
    "topic": "Topic Name",
    "difficulty": "Easy|Medium|Hard",
    "question": "The question text",
    "diagram": "Optional ASCII diagram",
    "hinglish_explanation": "Casual explanation",
    "real_life_example": "Real-world example",
    "how_to_answer": "Interview answer points"
  }
]
```

## 🛠 API Endpoints

| Endpoint | Description |
|----------|-------------|
| `GET /api/files` | List all JSON files with stats |
| `GET /api/data/{filename}` | Get content of specific file |
| `GET /api/all` | Get all questions combined |
| `GET /api/stats` | Get overall statistics |

## ⌨️ Keyboard Shortcuts

| Shortcut | Action |
|----------|--------|
| `Ctrl+K` | Focus search bar |
| `Escape` | Close modal |

## 💾 Data Persistence

Progress and bookmarks are saved in browser localStorage. They persist across browser sessions but are per-browser.

## 🔧 Requirements

- Python 3.6+ (no external packages needed)
- Any modern web browser
