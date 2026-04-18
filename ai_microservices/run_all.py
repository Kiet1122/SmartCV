import subprocess
import sys

def run_service(command):
    return subprocess.Popen(command, shell=True)

if __name__ == "__main__":
    print("🚀 Starting all AI microservices...")

    # 1. CV Parser (port 8080) - Dùng Groq/Llama 3.3
    service1 = run_service("uvicorn ai_microservices.cv_parser.main:app --port 8080")

    # 2. Semantic Matcher (port 8001) - Dùng Sentence-Transformers (Local)
    service2 = run_service("uvicorn ai_microservices.semantic_matcher.main:app --port 8001")

    # 3. CV Reviewer (port 8002) - Dùng Llama 3.1 8B (Ollama Local)
    service3 = run_service("uvicorn ai_microservices.cv_reviewer.main:app --port 8002")

    try:
        service1.wait()
        service2.wait()
        service3.wait()
    except KeyboardInterrupt:
        print("\nStopping all services...")
        service1.terminate()
        service2.terminate()
        service3.terminate()
        print("All services stopped successfully.")