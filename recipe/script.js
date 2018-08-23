
$(document).ready(function(){
$("#submit").click(function(){
var title = $("#title").val();
var making_time = $("#making_time").val();
var serves = $("#serves").val();
var ingredients = $("#ingredients").val();
var cost = $("#cost").val();
// Returns successful data submission message when the entered information is stored in database.
//var dataString = 'name='+ name + '&description='+ description + '&price='+ price + '&category_id='+ category_id;
var dataString = { title: title, making_time: making_time, serves: serves, ingredients: ingredients, cost: cost};
    dataString = JSON.stringify(dataString);
console.log(dataString);
if(title==''||making_time==''||serves==''||ingredients==''||cost=='')
{
alert("Please Fill All Fields");
}
else
{
$.ajax({
            type: 'POST',
            url: 'http://localhost/api/recipe/create.php', 
            contentType : 'application/json',
            data : dataString,
        })
        .done(function(data){
             dataText = JSON.stringify(data);
            // show the response
            $('#response').html(dataText);
            console.log (dataText);
             
        })
        .fail(function() {
         
            // just in case posting your form failed
            alert( "Posting failed." );
             
        });

}
return false;
});
});