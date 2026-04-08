// If you are using JavaScript/ECMAScript modules:
import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

document.addEventListener("DOMContentLoaded", () => {
  const dropzone = new Dropzone("#dropzone", {
    url: uploadUrl,
    paramName: "images",
    method: "POST",
    chunking: true,
    forceChunking: true,
    chunkSize: 10000000, // Set your desired chunk size in bytes
    parallelChunkUploads: true,
    retryChunks: true,
    retryChunksLimit: 3,
    maxFilesize: 2048, // Set your desired maximum file size in megabytes
    acceptedFiles: ".zip",
    autoProcessQueue: false,
    uploadMultiple: false,
    maxFiles: 1,
  });

  dropzone.on("sending", (file, xhr, formData) => {
    formData.append("manga_id", document.querySelector("[name='manga_id']").value);
    xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
    var dropzoneOnLoad = xhr.onload;
    xhr.onload = function (e) {
      dropzoneOnLoad(e);
    };
  });

  dropzone.on("success", (file, response) => {
    window.location.href = urlRedirect;
  });

  dropzone.on("error", (file, errorMessage) => {
    console.log(errorMessage);
  });

  document.querySelector("form").addEventListener("submit", (event) => {
    event.preventDefault();
    dropzone.processQueue();
  });
});
