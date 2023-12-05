function sortDivs() {
    // Get the select element
    var dropdown = document.getElementById("myDropdown");

    // Get the selected option value
    var selectedValue = dropdown.value;

    // Get the container of divs
    var container = document.body;

    // Get an array of div elements with the class "sortable-div"
    var divs = document.querySelectorAll('.sortable-div');

    // Convert the NodeList to an array for easier sorting
    var divsArray = Array.from(divs);

    // Sort the array based on the selected value
    divsArray.sort(function(a, b) {
        // You can customize this comparison based on your requirements
        var aValue = a.id === selectedValue ? 0 : 1;
        var bValue = b.id === selectedValue ? 0 : 1;
        return aValue - bValue;
    });

    // Clear the container
    container.innerHTML = "";

    // Append the sorted divs back to the container
    divsArray.forEach(function(div) {
        container.appendChild(div);
    });
}