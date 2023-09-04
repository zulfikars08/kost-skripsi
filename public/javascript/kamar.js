$(document).ready(function() {
    var searchInput = $('#search-input');
    var tableBody = $('#table-body');
    var paginationContainer = $('.pagination-container');
    
    var kamarIndexRoute = '{{ route('kamar.index') }}';

    function updateTable(keyword = '', page = 1) {
        $.ajax({
            url: kamarIndexRoute,
            type: 'GET',
            data: {
                katakunci: keyword,
                page: page,
                ajax: true
            },
            success: function(response) {
                tableBody.html($(response).find('#table-body').html());
                paginationContainer.html($(response).find('.pagination-container').html());
            }
        });
    }

    searchInput.on('input', function() {
        var keyword = searchInput.val().toLowerCase().trim();
        updateTable(keyword);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var pageUrl = $(this).attr('href');
        var page = pageUrl.split('page=')[1];
        updateTable('', page);
    });

    // Initial load
    updateTable();
});
