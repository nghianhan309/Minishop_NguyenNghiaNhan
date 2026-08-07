document.addEventListener("DOMContentLoaded", function() {
    var imgInput = document.getElementById("image");
    if(imgInput) {
        imgInput.addEventListener("change", function () {
            const preview = document.getElementById("preview");
            if(!preview) return;
            preview.innerHTML = "";
            const files = this.files;
            for (let i = 0; i < files.length; i++) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(files[i]);
                img.width = 150;
                img.className = "img-thumbnail m-1";
                preview.appendChild(img);
            }
        });
    }

    var imgsInput = document.getElementById("images");
    if(imgsInput) {
        imgsInput.addEventListener("change", function () {
            const preview2 = document.getElementById("preview-gallery");
            if(!preview2) return;
            preview2.innerHTML = "";
            const files = this.files;
            for (let i = 0; i < files.length; i++) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(files[i]);
                img.width = 100;
                img.className = "img-thumbnail m-1";
                preview2.appendChild(img);
            }
        });
    }
});