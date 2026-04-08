import Sortable from "sortablejs";
// import Dropzone from "dropzone";

document.addEventListener("DOMContentLoaded", function () {
  const uploadType = document.querySelector("#upload-type");
  const imageUpload = document.querySelector("#images-upload");
  const zipUpload = document.querySelector("#zip-upload");
  const inputDiv = document.querySelector(".input-div");
  const input = document.querySelector("#images");
  const imagesPreview = document.querySelector("#images-preview");
  const progressBarContainer = document.querySelector("#progress-bar-container");
  const progressBar = document.querySelector("#progress-bar");
  const chapterForm = document.querySelector("#chapter-form");
  const submitButton = chapterForm.querySelector("button[type='submit']");
  let imagesArray = [];

  if (uploadType) {
    function handleUploadTypeChange() {
      if (uploadType.value === "images") {
        imageUpload.classList.remove("hidden");
        zipUpload.classList.add("hidden");
      } else {
        imagesArray = [];
        displayImages();
        imageUpload.classList.add("hidden");
        zipUpload.classList.remove("hidden");
      }
    }

    handleUploadTypeChange();

    uploadType.addEventListener("change", handleUploadTypeChange);
  }

  input.addEventListener("change", handleInputChange);

  function handleInputChange() {
    imagesArray.push(...Array.from(input.files));
    displayImages();
  }

  function handleDragOver(e) {
    e.preventDefault();
  }

  function handleDrop(e) {
    e.preventDefault();
    const files = Array.from(e.dataTransfer.files);
    files
      .filter((file) => file.type.includes("image"))
      .forEach((file) => {
        if (!imagesArray.some((image) => image.name === file.name)) {
          imagesArray.push(file);
        }
      });

    displayImages();
  }

  inputDiv.addEventListener("dragover", handleDragOver);
  inputDiv.addEventListener("drop", handleDrop);

  function displayImages() {
    imagesPreview.innerHTML = imagesArray
      .map(
        (image, index) => `
        <div class="sortable-image w-60 h-fit bg-input p-3 rounded-md cursor-pointer" data-index="${index}">
          <div class="relative">
              <img src="${URL.createObjectURL(image)}" alt="image">
              <a class="bg-white w-6 h-6 rounded-full absolute right-2 top-2 text-white flex items-center justify-center rotate-45 cursor-pointer" id="delete-image-${index}">
                  &#x2716;
              </a>
          </div>
        </div>
      `
      )
      .join("");

    enableSorting();
  }

  function enableSorting() {
    new Sortable(imagesPreview, {
      animation: 150,
      draggable: ".sortable-image",
      onEnd: updateImagesOrder,
    });
  }

  function updateImagesOrder(evt) {
    const draggedImage = imagesArray.splice(evt.oldIndex, 1)[0];
    imagesArray.splice(evt.newIndex, 0, draggedImage);
  }

  chapterForm.addEventListener("submit", handleFormSubmit);

  function handleFormSubmit(event) {
    event.preventDefault();
    if (imagesArray.length > 0 || uploadType.value === "zip") {
      progressBarContainer.classList.remove("hidden");
    }
    submitButton.disabled = true;

    const formData = new FormData(chapterForm);
    formData.delete("images[]");

    imagesArray.forEach((image, index) => {
      formData.append("images[]", image, `image_${index}`);
    });

    const xhr = new XMLHttpRequest();
    xhr.open(chapterForm.method, chapterForm.action, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.upload.addEventListener("progress", handleUploadProgress);

    xhr.onreadystatechange = handleXHRStateChange;

    xhr.send(formData);
  }

  function handleUploadProgress(e) {
    if (e.lengthComputable) {
      const progress = (e.loaded / e.total) * 100;
      progressBar.style.width = `${progress}%`;
    }
  }

  function handleXHRStateChange() {
    if (this.readyState === XMLHttpRequest.DONE) {
      if (this.status === 200) {
        window.location.href = this.responseURL;
      }
      submitButton.disabled = false;
    }
  }

  imagesPreview.addEventListener("click", handleImageClick);

  function handleImageClick(event) {
    const targetId = event.target.id;
    if (targetId.startsWith("delete-image-")) {
      event.preventDefault();
      const index = parseInt(targetId.split("-")[2]);

      imagesArray.splice(index, 1);
      document.querySelector(`.sortable-image[data-index="${index}"]`).remove();
    }
  }
});
