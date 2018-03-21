//Getting all of the buttons within the addFriends table
var friendTable = document.getElementById("friendTable")
var buttonArr = friendTable.getElementsByTagName("a");

//Add friend to table
var addButton = document.getElementById("addButton");
addButton.addEventListener("click", addRow());

//When each button is clicked, the removeRow callback function is called with
//parameter being the row associated with the button to be removed
for(i = 0; i < buttonArr.length; i++){
  var currButton = buttonArr[i];
  var rowToRemove = currButton.parentNode.parentNode;
  buttonArr[i].addEventListener("click", removeRow(rowToRemove));
}

//The removeRow function gets the parentNode of the row, which is the <tbody> tag,
//and removes the specific row element using removeChild with the parentNode.
function removeRow(row){
  return function(){
    var tbody = row.parentNode;
    tbody.removeChild(row);
  }
}

//Gets the tbody node of the table and adds the new row to the html inside of the tag
//Then add listener to all buttons again. Had an issue where once the a new listener
//was added to the new button all of the other buttons did not work.
function addRow(){
  return function(){
    var tableNodes = friendTable.childNodes;
    var tbody = tableNodes[3];
    var friendInput = document.getElementById("addFriend");
    if(friendInput.value == ""){

    }
    else{
      tbody.innerHTML += "<tr>\n<td>" + friendInput.value + "<a class=\"btn btn-xs col-xs-1 pull-right button-new ubuntu-font\">-</a></td>\n</tr>";
      var buttonArr = friendTable.getElementsByTagName("a");
      for(i = 0; i < buttonArr.length; i++){
        var currButton = buttonArr[i];
        var rowToRemove = currButton.parentNode.parentNode;
        buttonArr[i].addEventListener("click", removeRow(rowToRemove));
      }
    }
  }
}
