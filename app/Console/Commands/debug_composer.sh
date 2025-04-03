#!/bin/bash

# Run the first command 'composer show foobar' and capture the output
debug_version_broken=$( /usr/local/bin/php /usr/bin/composer show foobar 2>&1 )

# Run the second command 'composer --version' and capture the output
debug_version_full=$( /usr/local/bin/php /usr/bin/composer --version 2>&1 )

# Create the JSON output
echo "{\"debug_version_broken\": \"$debug_version_broken\", \"debug_version_full\": \"$debug_version_full\"}"