#!/usr/bin/env python3
"""
Study Dashboard - Local Python Server
Serves JSON files from the 'data' folder and provides API endpoints.
Run: python server.py
Then open: http://localhost:8080
"""

import http.server
import json
import os
import socketserver
from pathlib import Path
from urllib.parse import urlparse, parse_qs

PORT = 8080
DATA_DIR = Path(__file__).parent / "data"
STATIC_DIR = Path(__file__).parent / "static"
BASE_DIR = Path(__file__).parent


class DashboardHandler(http.server.SimpleHTTPRequestHandler):
    """Custom handler for the study dashboard."""

    def __init__(self, *args, **kwargs):
        super().__init__(*args, directory=str(BASE_DIR), **kwargs)

    def do_GET(self):
        parsed = urlparse(self.path)
        path = parsed.path

        # API: List all JSON files
        if path == "/api/files":
            self._send_json(self._get_file_list())
            return

        # API: Get specific JSON file content
        if path.startswith("/api/data/"):
            filename = path.replace("/api/data/", "")
            self._serve_json_file(filename)
            return

        # API: Get all data combined
        if path == "/api/all":
            self._send_json(self._get_all_data())
            return

        # API: Get stats
        if path == "/api/stats":
            self._send_json(self._get_stats())
            return

        # Serve index.html for root
        if path == "/" or path == "":
            self.path = "/index.html"

        # Default file serving
        super().do_GET()

    def _get_file_list(self):
        """Get list of all JSON files in data directory."""
        files = []
        if DATA_DIR.exists():
            for f in sorted(DATA_DIR.glob("*.json")):
                try:
                    with open(f, "r", encoding="utf-8") as fp:
                        data = json.load(fp)
                    count = len(data) if isinstance(data, list) else 1
                    # Extract topics
                    topics = set()
                    if isinstance(data, list):
                        for item in data:
                            if isinstance(item, dict) and "topic" in item:
                                topics.add(item["topic"])
                    files.append({
                        "name": f.name,
                        "size": f.stat().st_size,
                        "questions": count,
                        "topics": sorted(topics)
                    })
                except (json.JSONDecodeError, Exception) as e:
                    files.append({
                        "name": f.name,
                        "size": f.stat().st_size,
                        "questions": 0,
                        "topics": [],
                        "error": str(e)
                    })
        return files

    def _serve_json_file(self, filename):
        """Serve a specific JSON file."""
        filepath = DATA_DIR / filename
        if not filepath.exists() or not filepath.suffix == ".json":
            self._send_json({"error": "File not found"}, status=404)
            return
        try:
            with open(filepath, "r", encoding="utf-8") as f:
                data = json.load(f)
            self._send_json(data)
        except Exception as e:
            self._send_json({"error": str(e)}, status=500)

    def _get_all_data(self):
        """Get all questions from all JSON files combined."""
        all_data = []
        if DATA_DIR.exists():
            for f in sorted(DATA_DIR.glob("*.json")):
                try:
                    with open(f, "r", encoding="utf-8") as fp:
                        data = json.load(fp)
                    if isinstance(data, list):
                        for item in data:
                            if isinstance(item, dict):
                                item["_source_file"] = f.name
                        all_data.extend(data)
                except Exception:
                    pass
        return all_data

    def _get_stats(self):
        """Get overall statistics."""
        all_data = self._get_all_data()
        topics = {}
        difficulties = {"Easy": 0, "Medium": 0, "Hard": 0}
        files_count = 0

        if DATA_DIR.exists():
            files_count = len(list(DATA_DIR.glob("*.json")))

        for item in all_data:
            if isinstance(item, dict):
                topic = item.get("topic", "Unknown")
                diff = item.get("difficulty", "Unknown")
                if topic not in topics:
                    topics[topic] = 0
                topics[topic] += 1
                if diff in difficulties:
                    difficulties[diff] += 1

        return {
            "total_questions": len(all_data),
            "total_files": files_count,
            "total_topics": len(topics),
            "topics": topics,
            "difficulties": difficulties
        }

    def _send_json(self, data, status=200):
        """Send JSON response."""
        self.send_response(status)
        self.send_header("Content-Type", "application/json; charset=utf-8")
        self.send_header("Access-Control-Allow-Origin", "*")
        self.end_headers()
        self.wfile.write(json.dumps(data, ensure_ascii=False).encode("utf-8"))

    def log_message(self, format, *args):
        """Custom log format."""
        if "/api/" in str(args[0]) or args[0] == '"GET / HTTP/1.1"':
            print(f"  [API] {args[0]}")


def main():
    print(f"""
╔══════════════════════════════════════════════════════════╗
║           📚 Study Dashboard Server                      ║
╠══════════════════════════════════════════════════════════╣
║  Server running at: http://localhost:{PORT}               ║
║  JSON data folder:  ./data/                              ║
║  Press Ctrl+C to stop                                    ║
╚══════════════════════════════════════════════════════════╝
    """)

    # Check data folder
    if not DATA_DIR.exists():
        DATA_DIR.mkdir(parents=True)
        print(f"  📁 Created data folder: {DATA_DIR}")

    json_files = list(DATA_DIR.glob("*.json"))
    if json_files:
        print(f"  📄 Found {len(json_files)} JSON file(s):")
        for f in json_files:
            print(f"     • {f.name}")
    else:
        print("  ⚠️  No JSON files found in ./data/ folder")
        print("     Place your JSON files there and refresh the browser.")

    print()

    with socketserver.TCPServer(("", PORT), DashboardHandler) as httpd:
        try:
            httpd.serve_forever()
        except KeyboardInterrupt:
            print("\n  ⛔ Server stopped.")
            httpd.shutdown()


if __name__ == "__main__":
    main()
