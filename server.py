import http.server
import socketserver
from urllib.parse import urlparse, unquote

PORT = 5000

class MyHandler(http.server.SimpleHTTPRequestHandler):
    def end_headers(self):
        self.send_header('Cache-Control', 'no-cache, no-store, must-revalidate')
        self.send_header('Pragma', 'no-cache')
        self.send_header('Expires', '0')
        super().end_headers()

    def do_GET(self):
        decoded_path = unquote(self.path)
        if '?' in decoded_path:
            path_part = decoded_path.split('?')[0]
        else:
            parsed = urlparse(decoded_path)
            path_part = parsed.path
        
        if path_part == '/':
            self.path = '/index.html'
        else:
            self.path = path_part
        return super().do_GET()

socketserver.TCPServer.allow_reuse_address = True
with socketserver.TCPServer(("0.0.0.0", PORT), MyHandler) as httpd:
    print(f"Server running at http://0.0.0.0:{PORT}")
    httpd.serve_forever()
