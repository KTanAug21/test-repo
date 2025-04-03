#!/bin/bash

# Run the first command 'composer show foobar' and capture the output
debug_version_broken=$( composer foobar 2>&1 )

# Run the second command 'composer --version' and capture the output
debug_version_full=$( composer  --version 2>&1 )

# Create the JSON output
echo "{\"debug_version_broken\": \"$debug_version_broken\", \"debug_version_full\": \"$debug_version_full\"}"
