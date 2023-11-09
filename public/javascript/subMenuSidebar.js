$(document).ready(function () {
    // Sembunyikan semua sub menu secara default
    $('.subbar').removeClass('show');
    
    // Tambahkan class 'show' pada sub menu yang aktif
    var activeSubMenu = $('[data-active="7"]').parent().find('.subbar');
    activeSubMenu.addClass('show');
    
    // Atur tindakan ketika link "Data Master" diklik
    $('[data-active="7"]').click(function () {
      // Ambil sub menu
      var subMenu = $(this).parent().find('.subbar');
      
      // Toggle class 'show' pada sub menu
      subMenu.toggleClass('show');
    });
  });