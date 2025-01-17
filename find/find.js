let isFileLinksVisible = false;
let clickCount = 0;

document.getElementById('toggleButton').addEventListener('click', function () {
    clickCount++;

    if (clickCount === 1) {
        fetchMDFileLinks();
    } else if (clickCount === 2) {
        clickCount = 0; // Reset click count  
        toggleFileLinksVisibility();
    }
});

function fetchMDFileLinks() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'find.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('fileLinks').innerHTML = xhr.responseText;
            isFileLinksVisible = true; // Set visibility to true after fetch  
            document.getElementById('fileLinks').style.display = 'block'; // Show the links  
            addLinkClickListeners(); // Add click listeners after content is loaded  
        } else {
            console.error('请求失败，状态码：', xhr.status);
        }
    };
    xhr.send();
}

function addLinkClickListeners() {
    // 为所有带有 'urlLink' 类的链接添加点击事件监听器  
    const links = document.querySelectorAll('.urlLink');

    links.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // 防止默认的锚点行为  

            const url = this.href; // 获取点击链接的 URL  
            const urlName = this.textContent; // 获取显示名称（链接文本）  
            const target = this.target; // Get the target attribute 
            // 用 h1 元素替换 div 内容  
            const fileLinksDiv = document.querySelector('.title1');
            fileLinksDiv.innerHTML = `<h1>${urlName}</h1>`;
            window.open(url, target); // Open the URL in a new tab 
            // 在短暂延迟后重定向到 URL（可选）  
            //setTimeout(() => {
            //    window.location.href = url; // 重定向到 URL
            //}, 1000); // 重定向前的延迟为 1 秒
        });
    });
}

function toggleFileLinksVisibility() {
    const fileLinks = document.getElementById('fileLinks');
    if (isFileLinksVisible) {
        fileLinks.style.display = 'none'; // Hide the links  
        isFileLinksVisible = false; // Update visibility  
    }
}