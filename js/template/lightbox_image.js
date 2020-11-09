var vue_lightbox = new Vue({
  el: '#lightbox',
  data: {
    visible: false,
    imgs: [

    ],
    edit:false,
    element_open:''
  },
  methods: {
    openfile:function(){
      $( this.element_open ).click();
    },
    showImg (index) {
      this.index = index
      this.visible = true
    },
    handleHide () {
      this.visible = false
    }
  }
})