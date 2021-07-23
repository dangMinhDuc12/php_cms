const checkboxAll = document.querySelector('#selectAllBoxes')
const checkboxChild = document.querySelectorAll('.checkBoxChild')
checkboxAll.onclick = function (e) {
    checkboxChild.forEach(item => item.checked = e.target.checked)
}