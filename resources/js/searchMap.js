// Ricerca e autocompletamento per creazione appartamento e modifica

window.searchBox = function() {
    var options = {
        searchOptions: {
            key: '6pyK2YdKNiLrHrARYvnllho6iAdjMPex',
            language: 'it-IT',
        },
        autocompleteOptions: {
            key: '6pyK2YdKNiLrHrARYvnllho6iAdjMPex',
            language: 'it-IT'
        }
    }
    
    var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
    var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
    document.getElementById('search-field').append(searchBoxHTML);
    
    document.querySelector('input.tt-search-box-input').name = 'address';
    document.querySelector('input.tt-search-box-input').id = 'search-for-coordinates';
    document.querySelector('input.tt-search-box-input').placeholder = 'Indirizzo';
}




