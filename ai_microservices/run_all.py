import subprocess
import sys

def run_service(command):
    return subprocess.Popen(command, shell=True)

if __name__ == "__main__":
    print("Starting all services...")

    # CV Parser (port 8000)
    service1 = run_service("uvicorn ai_microservices.cv_parser.main:app --port 8000")

    # Semantic Matcher (port 8001)
    service2 = run_service("uvicorn ai_microservices.semantic_matcher.main:app --port 8001")

    try:
        service1.wait()
        service2.wait()
    except KeyboardInterrupt:
        print("Stopping services...")
        service1.terminate()
        service2.terminate()