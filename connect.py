import sys
import lmstudio as lms

model = lms.llm("meta-llama-3.1-8b-instruct")

if len(sys.argv) > 1:
    user_query = sys.argv[1]
    result = model.respond(user_query)
    print(result)