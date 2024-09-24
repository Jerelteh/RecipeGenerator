document.getElementById('searchInput').addEventListener('input', function() {
    let query = this.value;

    if (query.length > 2) { // Only start searching after 3 characters
        fetch(`/search-suggestions?query=${query}`)
            .then(response => response.json())
            .then(data => {
                let suggestions = document.getElementById('searchSuggestions');
                suggestions.innerHTML = ''; // Clear previous suggestions

                data.forEach(item => {
                    let suggestion = document.createElement('a');
                    suggestion.href = `/recipe/${item.id}`;
                    suggestion.textContent = item.title;
                    suggestions.appendChild(suggestion);
                });

                if (data.length > 0) {
                    suggestions.style.display = 'block';
                } else {
                    suggestions.style.display = 'none';
                }
            });
    } else {
        document.getElementById('searchSuggestions').style.display = 'none';
    }
});
