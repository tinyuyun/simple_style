const select=document.querySelector(".select")
const options_list=document.querySelector(".options-list")
const options=document.querySelectorAll(".option")
//切换显示和隐藏
select.addEventListener("click",()=>{
    options_list.classList.toggle("active");
    select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up")
})