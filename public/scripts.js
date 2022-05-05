
function cashgameall() 
{
  // Ajax config
  $.ajax({
        type: "GET", //we are using GET method to get all record from the server
        url: 'instancia.php', // get the route value
        data: { new: 'BalanceController', funcao: 'getBalanceByIdAll'},
        success: function (response) {//once the request successfully process to the server side it will return result here
            
            // Parse the json result
          response = JSON.parse(response);

            var html = "";
            // Check if there is available records
            if(response.length) {
              
              // Loop the parsed JSON
              $.each(response, function(key,value) {
                // Our cashgame list template
          html += '<tr>';
          html += "<td>" + value.name + "</td>";
          html += "<td>" + value.value + "</td>";
          html += "<td><button class='btn btn-primary' data-toggle='modal' data-target='#view-cashgame-modal' data-id_caixa='"+value.id_caixa+"' data-id='"+value.id+"'>Visualizar</button></td>";
          html += '</tr>';
              });
            } else {
              html += '<td>';
          html += 'No records found!';
        html += '</td>';
            }

            // Insert the HTML Template and display all records
      $("#cashgame-list").html(html);
        }
    });
}

function save() 
{
  $("#btnSubmit").on("click", function() {
    var $this         = $(this); //submit button selector using ID
        var $caption        = $this.html();// We store the html content of the submit button
        var form      = "#form"; //defined the #form ID
        var formData        = $(form).serializeArray(); //serialize the form into array
        var route       = $(form).attr('action'); //get the route using attribute action

        // Ajax config
      $.ajax({
          type: "POST", //we are using POST method to submit the data to the server side
          url: route, // get the route value
          data: formData, // our serialized array data for server side
          beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
              $this.attr('disabled', true).html("Processing...");
          },
          success: function (response) {//once the request successfully process to the server side it will return result here
              $this.attr('disabled', false).html($caption);

              // Reload lists of employees
              cashgameall();

              // We will display the result using alert
              alert(response);

              // Reset form
              resetForm(form);
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            // You can put something here if there is an error from submitted request
          }
      });
  });
}

function resetForm(selector) 
{
  $(selector)[0].reset();
}


function get() 
{
  $(document).delegate("[data-target='#view-cashgame-modal']", "click", function() {

    var Id = $(this).attr('data-id');
    var Id_caixa = $(this).attr('data-id_caixa');

    // Ajax config
    $.ajax({
          type: "GET", //we are using GET method to get data from server side
          url: 'instancia.php', // get the route value
          data: {new: 'ExtractController', funcao: 'getPerCaixa', id:Id, id_caixa:Id_caixa}, //set data
          beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
              
          },
          success: function (response) {//once the request successfully process to the server side it will return result here
              response = JSON.parse(response);

            $("#view-form [name=\"id\"]").val(response.id);

            var html = "";
            // Check if there is available records
            if(response.length) {
              
              // Loop the parsed JSON
              $.each(response, function(key,value) {
                // Our list transaction template
                html += '<tr>';
                html += "<td>" + value.name + "</td>";
                html += "<td>" + value.value + "</td>";
                html += "<td>" + value.id_caixa + "</td>";
                html += "<td>" + value.created_at + "</td>";
                html += '</tr>';

                var total = response.reduce(getTotal, 0);
                function getTotal(total, value) {
                return total - value.value;
                }

                $("#view-form [name=\"total\"]").val(total);
                    });
                  } else {
                    html += '<td>';
                html += 'No records found!';
              html += '</td>';
                }

            // Insert the HTML Template and display all employee records
      $("#transaction-list").html(html);
          }
      });
  });
}

function update() 
{
  $("#btnUpdateSubmit").on("click", function() {
    var $this         = $(this); //submit button selector using ID
        var $caption        = $this.html();// We store the html content of the submit button
        var form      = "#view-form"; //defined the #form ID
        var formData        = $(form).serializeArray(); //serialize the form into array
        var route       = $(form).attr('action'); //get the route using attribute action

        // Ajax config
      $.ajax({
          type: "POST", //we are using POST method to submit the data to the server side
          url: route, // get the route value
          data: formData, // our serialized array data for server side
          beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
              $this.attr('disabled', true).html("Processing...");
          },
          success: function (response) {//once the request successfully process to the server side it will return result here
              $this.attr('disabled', false).html($caption);

              // Reload lists of employees
              cashgameall();

              // We will display the result using alert
              alert(response);

              // Reset form
              resetForm(form);

              // Close modal
              $('#view-cashgame-modal').modal('toggle');
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            // You can put something here if there is an error from submitted request
          }
      });
  });
}


$(document).ready(function() {

  // Get all employee records
  cashgameall();

  // Submit form using AJAX To Save Data
  save();

  // Get the data and view to modal
  get();
   
  // Updating the data
  update();
});