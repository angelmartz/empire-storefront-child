(function ($, window, document) {
  $(document).ready(function() {
    var $responsiveTables = $('.responsive-table');
   
    if ( $responsiveTables ) {
      $responsiveTables.each(function(index) {
        var rows = $(this).find('tr');
        var headerCells = $(this).find('thead tr').children();
        var headerValues = [];

        headerCells.each(function() {
          headerValues.push(this.innerText);
        });

        rows.each(function() {
          var $cells = $(this).children();
          $cells.each(function(index) {
            $(this).attr('data-th', headerValues[index]);
          });
        });

        headerValues = [];
      });
    } else {
      return;
    }
   
  });
}(jQuery, window, document));
