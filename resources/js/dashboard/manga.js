import TomSelect from "tom-select";

new TomSelect("#input-tags", {
  plugins: {
    remove_button: {
      title: "Remove this item",
    },
    restore_on_backspace: {},
    clear_button: {
      title: "Remove all selected options",
    },
    // checkbox_options: {},
  },

  persist: false,
  createOnBlur: true,
  create: true,
});
