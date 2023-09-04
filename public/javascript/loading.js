
function showLoadingOverlay() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}


function hideLoadingOverlay() {
    document.getElementById('loadingOverlay').style.display = 'none';
}

function simulateLoading() {
    showLoadingOverlay();
    setTimeout(() => {
        hideLoadingOverlay();
    }, 1000); 
}
simulateLoading();
