// import "./bootstrap";
import "lazysizes";
import "animate.css";

document.addEventListener("DOMContentLoaded", function () {
  const userMenuButton = document.querySelector("#user-menu-button");
  const userMenu = document.querySelector("#user-menu");
  const searchLink = document.querySelector("#search-link");
  const searchLinkPhone = document.querySelector("#search-link-phone");
  const navSearch = document.querySelector("#nav-search");
  const commentInput = document.querySelector("#comment");
  const commentCharCount = document.querySelector("#comment-char");
  const showChapters = document.querySelector("#showChapters");
  const showInfo = document.querySelector("#showInfo");
  const chaptersList = document.querySelector("#chapters-list");
  const commentsList = document.querySelector("#comments-list");
  const sliderMangas = document.querySelector("#home-slider");
  const popularMangas = document.querySelector("#popular-mangas");
  const latestMangas = document.querySelector("#latest-mangas");
  const suggestedMangas = document.querySelector("#suggested-mangas");
  const logoutBtn = document.querySelector("#logout-button");
  const dropdownBtns = document.querySelectorAll(".dropdown-btn");
  const dropdownMenus = document.querySelectorAll(".dropdown-menu");
  const titleInput = document.querySelector("#title");
  const slugInput = document.querySelector("#slug");
  const forms = document.querySelectorAll("form");
  const darkToggle = document.querySelector("#dark-toggle");
  const darkMode = localStorage.getItem("darkMode");
  const adTypeSelect = document.querySelector("#ad-type");
  const adBannerDiv = document.querySelector("#ad-banner");
  const adScriptDiv = document.querySelector("#ad-script");
  const chapterImages = document.querySelectorAll(".chapter-image");
  const chapterSelect = document.querySelectorAll("#chapter-select");
  const editor = document.getElementsByClassName("toastui-editor-defaultUI")[0];

  if (chapterImages) {
    chapterImages.forEach((image) => {
      image.addEventListener("click", function (e) {
        e.preventDefault();
        window.scroll(0, window.scrollY + 500);
      });
    });
  }

  if (chapterSelect) {
    chapterSelect.forEach((select) => {
      select.addEventListener("change", function (e) {
        e.preventDefault();
        window.location.href = window.location.href.replace(/\d+$/, e.target.value);
      });
    });
  }
  if (titleInput && slugInput) {
    titleInput.addEventListener("keyup", function () {
      const title = titleInput.value.trim();
      const slug = title.replace(/\s+/g, "-").replace(/-$/, "");
      slugInput.value = slug.toLowerCase();
    });
  }

  if (logoutBtn) {
    logoutBtn.addEventListener("click", function (e) {
      e.preventDefault();
      logoutBtn.parentNode.submit();
    });
  }

  if (userMenuButton) {
    userMenuButton.addEventListener("click", function (e) {
      e.preventDefault();
      userMenu?.classList.toggle("absolute");
      userMenu?.classList.toggle("flex");
      userMenu?.classList.toggle("hidden");
    });
  }

  if (localStorage.getItem("darkMode") === "false") {
    if (document.querySelector("html")?.classList?.contains("dark")) {
      document.querySelector("html")?.classList?.remove("dark");
    }
  }

  if (darkToggle) {
    darkToggle.addEventListener("click", function (e) {
      e.preventDefault();
      let isDark = document.querySelector("html")?.classList?.contains("dark") ? true : false;
      localStorage.setItem("darkMode", !isDark);
      document.querySelector("html")?.classList?.toggle("dark");

      // if editor
      if (editor) {
        if (editor.classList?.contains("toastui-editor-dark")) {
          editor.classList?.remove("toastui-editor-dark");
        } else {
          editor.classList?.add("toastui-editor-dark");
        }
      }
    });
  }

  const toggleNavSearch = (e) => {
    e.preventDefault();

    // animate first, then hide
    if (navSearch?.classList.contains("block")) {
      navSearch?.classList.add("animate__fadeOutUp");
      navSearch?.classList.remove("animate__fadeInDown");

      setTimeout(() => {
        navSearch?.classList.remove("block");
        navSearch?.classList.add("hidden");
      }, 600);
    }

    // Display first, then animate
    if (navSearch?.classList.contains("hidden")) {
      navSearch?.classList.remove("hidden");
      navSearch?.classList.add("block");

      navSearch?.classList.add("animate__fadeInDown");
      navSearch?.classList.remove("animate__fadeOutUp");
    }
  };

  if (searchLink) {
    searchLink.addEventListener("click", toggleNavSearch);
  }

  if (searchLinkPhone) {
    searchLinkPhone.addEventListener("click", toggleNavSearch);
  }

  if (commentInput && commentCharCount) {
    commentInput.addEventListener("keyup", function (e) {
      const length = e.target.value.length;
      commentCharCount.innerHTML = length;
    });
  }

  if (showChapters && showInfo && chaptersList && commentsList) {
    showChapters.addEventListener("click", function (e) {
      e.preventDefault();
      chaptersList?.classList.remove("hidden");
      commentsList?.classList.add("hidden");
      showChapters?.classList.add("tab-active");
      showInfo?.classList.remove("tab-active");
    });

    showInfo.addEventListener("click", function (e) {
      e.preventDefault();
      chaptersList?.classList.add("hidden");
      commentsList?.classList.remove("hidden");
      showChapters?.classList.remove("tab-active");
      showInfo?.classList.add("tab-active");
    });
  }

  dropdownBtns.forEach((dropdownBtn) => {
    const dropdownMenu = dropdownBtn.nextElementSibling;

    dropdownBtn.addEventListener("click", () => {
      dropdownMenus.forEach((menu) => {
        if (menu !== dropdownMenu) {
          menu.classList.add("hidden");
          menu.classList.remove("animate-fadeIn");
        }
      });

      dropdownMenu.classList.toggle("hidden");
      dropdownMenu.classList.toggle("animate-fadeIn");

      const dropdownMenuRect = dropdownMenu.getBoundingClientRect();
      if (dropdownMenuRect.right + dropdownMenuRect.width > window.innerWidth) {
        dropdownMenu.style.right = "0";
        dropdownMenu.style.left = "auto";
      }
    });
  });

  document.addEventListener("click", (e) => {
    if (!e.target.closest(".dropdown-btn")) {
      dropdownMenus.forEach((menu) => {
        if (!menu.classList.contains("hidden")) {
          menu.classList.add("hidden");
          menu.classList.remove("animate-fadeIn");
        }
      });
    }

    if (!e.target.matches("#user-menu") && !e.target.closest("#user-menu-button")) {
      userMenu?.classList.add("hidden");
      userMenu?.classList.remove("absolute");
      userMenu?.classList.remove("flex");
    }
  });

  function initializeSwiper(containerSelector, options = {}) {
    const swiperEl = document.querySelector(containerSelector);
    if (!swiperEl) return;

    swiperEl.style.display = "block";

    Object.assign(swiperEl, {
      spaceBetween: 10,
      ...options,
    });

    if (typeof swiperEl.initialize === "function") {
      swiperEl.initialize();
    }
  }

  const swipterSettings = {
    breakpoints: {
      0: { slidesPerView: 3, spaceBetween: 10 },
      640: { slidesPerView: 4 },
      768: { slidesPerView: 6 },
      1200: { slidesPerView: 10 },
    }
  };

  if (sliderMangas) {
    initializeSwiper("#home-slider", {
      slidesPerView: 1,
      spaceBetween: 10,
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
    });
  }

  if (popularMangas) {
    initializeSwiper("#popular-mangas", swipterSettings);
    popularMangas?.classList.remove("!hidden");
  }

  if (latestMangas) {
    initializeSwiper("#latest-mangas", swipterSettings);
    latestMangas?.classList.remove("!hidden");
  }

  if (suggestedMangas) {
    initializeSwiper("#suggested-mangas", {
      breakpoints: {
        0: { slidesPerView: 3, spaceBetween: 10 },
        640: { slidesPerView: 4 },
        768: { slidesPerView: 6 },
        1200: { slidesPerView: 8 },
      }
    });
    suggestedMangas?.classList.remove("!hidden");
  }

  forms.forEach((form) => {
    form.addEventListener("submit", (event) => {
      const submitButton = form.querySelector('button[type="submit"]');
      const btnText = form.querySelector('button[type="submit"] #btn-text');
      const btnLoader = form.querySelector('button[type="submit"] #btn-loader');
      submitButton.disabled = true;
      submitButton.classList.add("disabled:cursor-not-allowed");
      btnLoader.classList.remove("hidden");
      if (form.querySelector('button[type="submit"] #btn-icon')) {
        btnLoader.classList.add("!right-[50%]");
        form.querySelector('button[type="submit"] #btn-icon').classList.add("hidden");
      }

      btnText.textContent = `${language.submitting}...`;
    });
  });

  if (adTypeSelect) {
    function handleAdTypeChange() {
      if (adTypeSelect.value === "banner") {
        adBannerDiv.classList.remove("hidden");
        adScriptDiv.classList.add("hidden");
      } else {
        adBannerDiv.classList.add("hidden");
        adScriptDiv.classList.remove("hidden");
      }
    }

    handleAdTypeChange();

    adTypeSelect.addEventListener("change", handleAdTypeChange);
  }
});
