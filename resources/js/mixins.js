
const mixins = {
    methods: {
        digitToAlphabet: digit => String.fromCharCode(digit + 64),
        isEmptyOrNull: obj => obj == null || obj === "",
        findIndex: (array, key, value) => array.findIndex(item => item[key] === value),
        fileUrl: file => URL.createObjectURL(file),
        imageRatio: url => {
            return new Promise((resolve, reject) => {
                const image = new Image();

                image.onload = function () {
                    resolve(this.width / this.height);
                };

                image.onerror = () => reject;
                image.src = url;
            })
        },
        base64toFile: (base64string, filename) => {
            var arr = base64string.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);

            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }

            return new File([u8arr], filename, {type:mime});
        }
    }
};

export default mixins;
