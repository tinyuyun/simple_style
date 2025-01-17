const select=document.querySelector(".select")
const options_list=document.querySelector(".options-list")
const options=document.querySelectorAll(".option")
//切换语言菜单得显示和隐藏
select.addEventListener("click",()=>{
    options_list.classList.toggle("active");
    select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up")
})
//切换语言
options.forEach((option)=>{
    option.addEventListener("click",()=>{
        options.forEach((option)=>{option.classList.remove("selected")});
        select.querySelector("span").innerHTML=option.innerHTML;
        option.classList.add("selected");
        options_list.classList.toggle("active")
        select.querySelector(".fa-angle-up").classList.toggle("fa-angle-up")
    })
})