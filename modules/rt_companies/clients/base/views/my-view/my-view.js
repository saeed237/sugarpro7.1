({
    className: 'my-view tcenter',

    cubeOptions: {
        spin: false
    },

    events: {
        'click .sugar-cube': 'spinCube'
    },

    spinCube: function() {
        this.cubeOptions.spin = !this.cubeOptions.spin;
        this.render();
    }
})