$(document).ready(function () {
  console.log("hello");
  $(".js-user-autocomplete").each(function () {
    console.log("hello");
    var autocompleteUrl = $(this).data("autocomplete-url");

    $(this).autocomplete({ hint: true }, [
      {
        source: function (query, cb) {
          $.ajax({
            url: autocompleteUrl + "?query=" + query,
          }).then(function (data) {
            cb(data.users);
          });
        },
        displayKey: "email",
        debounce: 200, //  only request every 1/2 second
      },
    ]);
  });
});
