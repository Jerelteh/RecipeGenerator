<link rel="stylesheet" href="{{ asset('css/searchBar.css') }}">

<div id="search-bar-container">
    <div class="search-container">
        <form action="{{ route('search.recipes') }}" method="GET" id="searchForm">
            <div class="search-bar">
                <input type="text" id="searchInput" name="query" placeholder="Search for recipes..."
                    autocomplete="off" style="padding-left: 15px">
                <button type="submit">
                    <span class="material-symbols-outlined" style="padding-top: 5px; padding-right: 5px;">
                        search
                    </span>
                </button>
            </div>
        </form>
        <div id="searchSuggestions" class="search-suggestions"></div>
    </div>
</div>
