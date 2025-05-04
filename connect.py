import sys
import lmstudio as lms
import json

model = lms.llm("bielik-11b-v2.3-instruct")

if len(sys.argv) > 2:
    user_query = sys.argv[1]
    history_json = sys.argv[2]

    try:
        history = json.loads(history_json)
    except json.JSONDecodeError:
        history = []

    messages = []
    for item in history:
        messages.append({"role": "user", "content": item["prompt"]})
        messages.append({"role": "assistant", "content": item["completion"]})

    messages.append({"role": "user", "content": user_query})

    result = model.respond({"messages": messages})
    print(result)

elif len(sys.argv) > 1:
    user_query = sys.argv[1]
    result = model.respond(user_query)
    print(result)
else:
    print("Brak zapytania użytkownika.")