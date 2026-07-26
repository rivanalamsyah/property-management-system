#!/bin/bash
URL="http://localhost"
STATUS=$(curl -o /dev/null -s -w "%{http_code}\n" $URL)

if [ $STATUS -eq 200 ]; then
    echo "Healthcheck passed: HTTP 200"
    exit 0
else
    echo "Healthcheck failed: HTTP $STATUS"
    exit 1
fi
