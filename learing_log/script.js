// 选择所有需要的元素
const filterItem = document.querySelector(".items"); // 过滤项
const filterImg = document.querySelectorAll(".gallery .image"); // 所有图片

window.onload = () => { // 窗口加载后
  filterItem.onclick = (selectedItem) => { // 如果用户点击了 filterItem div
    if (selectedItem.target.classList.contains("item")) { // 如果用户选择的项有 .item 类
      filterItem.querySelector(".active").classList.remove("active"); // 移除当前活动项的 active 类
      selectedItem.target.classList.add("active"); // 将活动类添加到用户选择的项上
      let filterName = selectedItem.target.getAttribute("data-name"); // 获取用户选择项的 data-name 值并存储在 filterName 变量中
      filterImg.forEach((image) => {
        let filterImges = image.getAttribute("data-name"); // 获取图像的 data-name 值
        // 如果用户选择的项的 data-name 值等于图像的 data-name 值
        // 或者用户选择的项的 data-name 值为 "all"
        if ((filterImges == filterName) || (filterName == "all")) {
          image.classList.remove("hide"); // 首先移除图像的 hide 类
          image.classList.add("show"); // 添加 show 类到图像
        } else {
          image.classList.add("hide"); // 在图像上添加 hide 类
          image.classList.remove("show"); // 移除图像的 show 类
        }
      });
    }
  }
  for (let i = 0; i < filterImg.length; i++) {
    filterImg[i].setAttribute("onclick", "preview(this)"); // 为所有可用的图像添加 onclick 属性
  }
}
// 全屏图像预览功能
// 选择所有需要的元素
const previewBox = document.querySelector(".preview-box"), // 预览框
    categoryName = previewBox.querySelector(".title p"), // 类别名称
    previewImg = previewBox.querySelector("img"), // 预览图像
    closeIcon = previewBox.querySelector(".icon"), // 关闭图标
    shadow = document.querySelector(".shadow"); // 背景阴影

function preview(element) {
  // 用户点击任何图像后，移除 body 的滚动条，使用户无法上下滚动
  document.querySelector("body").style.overflow = "hidden";
  let selectedPrevImg = element.querySelector("img").src; // 获取用户点击图像的源链接并存储在变量中
  let selectedImgCategory = element.getAttribute("data-name"); // 获取用户点击图像的 data-name 值
  previewImg.src = selectedPrevImg; // 将用户点击的图像源传递到预览图像源
  categoryName.textContent = selectedImgCategory; // 将用户点击的数据名称传递到类别名称
  previewBox.classList.add("show"); // 显示预览图像框
  shadow.classList.add("show"); // 显示浅灰色背景
  closeIcon.onclick = () => { // 如果用户点击预览框的关闭图标
    previewBox.classList.remove("show"); // 隐藏预览框
    shadow.classList.remove("show"); // 隐藏浅灰色背景
    document.querySelector("body").style.overflow = "auto"; // 显示 body 的滚动条
  }
}