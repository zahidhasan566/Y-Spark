<template>
    <main>
        <div class="o-vertical-spacing o-vertical-spacing--l">
            <div class="blog-post o-media">
                <div class="o-media__body">
                    <div class="o-vertical-spacing">
                        <span class="skeleton-box" :style="`width:${randomNumber(80,100)}%;`" v-for="n in row"></span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
export default {
    props:['row'],
    methods:{
        randomNumber(min, max) {
            return Math.random() * (max - min) + min;
        }
    }
}
</script>
<style scoped>
.skeleton-box {
    display: inline-block;
    height: 1em;
    position: relative;
    overflow: hidden;
    background-color: #DDDBDD;

    &::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        transform: translateX(-100%);
        background-image: linear-gradient(
                90deg,
                rgba(#fff, 0) 0,
                rgba(#fff, 0.2) 20%,
                rgba(#fff, 0.5) 60%,
                rgba(#fff, 0)
        );
        animation: shimmer 2s infinite;
        content: '';
    }

    @keyframes shimmer {
        100% {
            transform: translateX(100%);
        }
    }
}

.blog-post {
    &__headline {
        font-size: 1.25em;
        font-weight: bold;
    }

    &__meta {
        font-size: 0.85em;
        color: #6b6b6b;
    }
}
.o-media {
    display: flex;

    &__body {
        flex-grow: 1;
    }
}

.o-vertical-spacing {
    > * + * {
        margin-top: 0.75em;
    }

    &--l {
        > * + * {
            margin-top: 2em;
        }
    }
}

main {
    margin-top: 1em;
}

</style>
