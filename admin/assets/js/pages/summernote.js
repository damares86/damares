$("#summernote").summernote({
  tabsize: 2,
  height: 400,
  lang:"it-IT",
  toolbar: [
    ['misc',['undo','redo']],
    ['style', ['style']],
    ['font', ['bold','italic','underline', 'clear']],
    ['fontname', ['fontname','fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['table', ['table']],
    ['insert', ['link', 'picture', 'video']],
    ['view', ['fullscreen', 'codeview', 'help']],
  ],
})
$("#hint").summernote({
  height: 100,
  toolbar: false,
  placeholder: "type with apple, orange, watermelon and lemon",
  hint: {
    words: ["apple", "orange", "watermelon", "lemon"],
    match: /\b(\w{1,})$/,
    search: function (keyword, callback) {
      callback(
        $.grep(this.words, function (item) {
          return item.indexOf(keyword) === 0
        })
      )
    },
  },
})
