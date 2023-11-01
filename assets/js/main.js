$(document).ready(function() {
    $(".arrow-link").click(function(e) {
        e.preventDefault();
        var icon = $(this).find(".arrow-icon");
        if (icon.hasClass("fa-chevron-down")) {
            icon.removeClass("fa-chevron-down").addClass("fa-chevron-up");
        } else {
            icon.removeClass("fa-chevron-up").addClass("fa-chevron-down");
        }
    });
});
const chooseAvatar = document.getElementById('chooseAvatar');
const fileInputAvatar = document.getElementById('fileInputAvatar');
const textAvatar = document.getElementById('textAvatar');
const chooseDegree = document.getElementById('chooseDegree');
const fileInputDegree = document.getElementById('fileInputDegree');
const textDegree = document.getElementById('textDegree');

//Avatar
chooseAvatar.addEventListener('click', () => {
    fileInputAvatar.click(); // Kích hoạt sự kiện click cho input file
});
fileInputAvatar.addEventListener('change', () => {
    textAvatar.textContent = `Tệp đã chọn: ${fileInputAvatar.value}`;
});
//Degree
chooseDegree.addEventListener('click', () => {
    fileInputDegree.click(); // Kích hoạt sự kiện click cho input file
});
fileInputDegree.addEventListener('change', () => {
    textDegree.textContent = `Tệp đã chọn: ${fileInputDegree.value}`;
});