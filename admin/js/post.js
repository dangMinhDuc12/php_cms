const checkboxAll = document.querySelector('#selectAllBoxes')
const checkboxChild = document.querySelectorAll('.checkBoxChild')
checkboxAll.onclick = function (e) {
    checkboxChild.forEach(item => item.checked = e.target.checked)
}

const div_box = "<div id='load-screen'><div id='loading'></div></div>";
$('body').prepend(div_box);

//Jquery: Hàm delay trì hoãn hàm đằng sau nó một khoảng thời gian nhất định, hàm fadeout là animation làm mờ và làm trong suốt element được gọi, callback của nó sẽ được thực thi khi animation hoàn thành

$('#load-screen').delay(700).fadeOut(600, function () {
    $(this).remove();
})