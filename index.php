<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HTTP Request Smuggling</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: radial-gradient(circle at top, #0f172a, #020617);
            color: #e5e7eb;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 80px auto;
            padding: 40px;
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.6);
        }

        h1 {
            font-size: 2.4rem;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 40px;
        }

        .section {
            margin-bottom: 35px;
            padding: 25px;
            background: rgba(2, 6, 23, 0.8);
            border-radius: 12px;
            border-left: 4px solid #38bdf8;
        }

        .section h2 {
            margin-bottom: 15px;
            font-size: 1.4rem;
            color: #e2e8f0;
        }

        .section p {
            color: #cbd5f5;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            margin: 10px 10px 0 0;
            padding: 12px 26px;
            background: linear-gradient(135deg, #0284c7, #0ea5e9);
            color: #020617;
            text-decoration: none;
            border-radius: 999px;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(14, 165, 233, 0.4);
        }

        .btn.danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: #020617;
        }

        code {
            display: block;
            margin-top: 15px;
            padding: 15px;
            background: #020617;
            border-radius: 10px;
            color: #38bdf8;
            font-family: Consolas, monospace;
            overflow-x: auto;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #64748b;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>HTTP Request Smuggling Lab</h1>
        <p class="subtitle">
            Hands-on laboratory for understanding and exploiting HTTP Request Smuggling vulnerabilities
        </p>

        <div class="section">
            <h2>Vulnerable Endpoints</h2>
            <p>
                The following endpoints simulate a front-end / back-end desync scenario
                using conflicting Content-Length and Transfer-Encoding headers.
            </p>

            <a href="vulnerable.php" class="btn danger">Vulnerable Page (CL-TE)</a>
            <a href="admin.php" class="btn">Admin Panel (Victim)</a>
        </div>

        <div class="section">
            <h2>Attack Workflow</h2>
            <p>• Exploit the desynchronization using a crafted HTTP request</p>
            <p>• Observe request queue poisoning behavior</p>
            <p>• Target the admin endpoint as a victim</p>

            <code>
python3 exploit.py
            </code>
        </div>

        <div class="section">
            <h2>Documentation & Resources</h2>
            <p>
                Use Burp Suite or a custom script to analyze and exploit the behavior.
            </p>
            <a href="https://github.com/M-thefl/HTTP-Smuggling" class="btn">
                GitHub Repository
            </a>
        </div>

        <footer>
            HTTP Smuggling 
        </footer>
    </div>
</body>
</html>
