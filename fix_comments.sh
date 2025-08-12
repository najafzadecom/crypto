#!/bin/bash

# Fix broken comments in model files
for file in app/Models/*.php; do
    # Skip translation models
    if [[ "$file" == *"Translation.php" ]]; then
        continue
    fi
    
    # Skip non-translatable models
    if [[ "$file" == *"User.php" ]] || [[ "$file" == *"Role.php" ]] || [[ "$file" == *"Permission.php" ]] || [[ "$file" == *"Setting.php" ]] || [[ "$file" == *"Language.php" ]] || [[ "$file" == *"ActivityLog.php" ]] || [[ "$file" == *"Order.php" ]] || [[ "$file" == *"Transaction.php" ]]; then
        continue
    fi
    
    echo "Fixing comments in $file"
    
    # Fix broken /** comments
    sed -i '' 's/^[[:space:]]*\* Get the translations/    \/\*\*\
     \* Get the translations/' "$file"
    
    sed -i '' 's/^[[:space:]]*\* Get the translation model/    \/\*\*\
     \* Get the translation model/' "$file"
    
    sed -i '' 's/^[[:space:]]*\* Apply global scopes/    \/\*\*\
     \* Apply global scopes/' "$file"
    
    # Fix any /* comments that should be /**
    sed -i '' 's/^[[:space:]]*\/\*[[:space:]]*$/    \/\*\*/' "$file"
    
done

echo "Comments fixed!"
