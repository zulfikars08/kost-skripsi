
$(document).ready(function() {
    // Original data (you can replace this with your actual data)
    var originalData = [
        { name: "Item 1", value: "value1" },
        { name: "Item 2", value: "value2" },
        // ... more data ...
    ];

    // Populate the autocomplete suggestions
    function populateAutocomplete(data) {
        $("#search-input").autocomplete({
            source: data.map(item => item.name),
            select: function(event, ui) {
                // Handle selection
                // You can find the selected item value using ui.item.value
            }
        });
    }

    // Initialize autocomplete with original data
    populateAutocomplete(originalData);

    // Clear search input and revert to original data
    $("#clear-button").click(function() {
        $("#search-input").val("");
        populateAutocomplete(originalData);
    });
});

