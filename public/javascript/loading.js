function showLoadingOverlay() {
      document.getElementById('loading-overlay').style.display = 'flex';
    }

    function hideLoadingOverlay() {
      document.getElementById('loading-overlay').style.display = 'none';
    }

    // Event listener for menu links
    document.querySelectorAll('.tooltip-element a').forEach(function(link) {
      link.addEventListener('click', function() {
        showLoadingOverlay();
      });
    });

    // Event listener for submenu links
    document.querySelectorAll('.submenu a').forEach(function(subLink) {
      subLink.addEventListener('click', function() {
        showLoadingOverlay();
      });
    });