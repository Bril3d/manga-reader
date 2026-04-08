import Editor from "@toast-ui/editor";

import "@toast-ui/editor/dist/toastui-editor.css"; // Editor's Style
import "@toast-ui/editor/dist/theme/toastui-editor-dark.css"; // Editor's Style

const editor = new Editor({
  el: document.querySelector("#editor"),
  previewStyle: "tab",
  height: "500px",
  initialValue: document.querySelector("#content")?.value || document.querySelector("#description")?.value,
  theme: JSON.parse(localStorage.getItem("darkMode")) ? "dark" : "default",
  usageStatistics: false,
  initialEditType: "wysiwyg",
});

document.querySelector("#form-editor").addEventListener("submit", (e) => {
  e.preventDefault();

  if (document.querySelector("#content")) {
    document.querySelector("#content").value = editor.getMarkdown();
  } else {
    document.querySelector("#description").value = editor.getMarkdown();
  }

  e.target.submit();
});
