<template>
  <div class="editor">
    <div class="editor__header">
      <template v-for="(command, index) in commands">
        <div class="divider" v-if="command.type === 'divider'" :key="`divider${index}`" />
        <button v-else
            class="menu-item"
            :class="{ 'is-active': command.isActive ? command.isActive(): null}"
            @click="command.action" :title="command.title">
          <i :class="command.icon" v-if="command.icon"></i>
          <div class="svg-icon" v-else-if="command.svg" v-html="command.svg"></div>
          <small v-else> {{ command.title }} </small>
        </button>
      </template>
      <button class="menu-item ms-auto" :class="{'is-active': showGeneratedCode}" @click="showGeneratedCode = !showGeneratedCode">
        <i class="fa-brands fa-html5 fs-2"></i>
      </button>
    </div>

    <editor-content class="editor__content" :editor="editor" v-if="!showGeneratedCode"/>
    <div class="min-h-200px p-2" v-else>
      <code>{{ modelValue }}</code>
    </div>
  </div>
</template>

<script>
import {Editor, EditorContent} from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit';

export default {
  name: "Editor",
  emits: ['update:modelValue'],
  components: {
    EditorContent,
  },
  props: {
    modelValue: {
      type: String,
      default: '',
    },
  },
  mounted() {
    // this.editor = new Editor({
    //   extensions: [
    //     StarterKit,
    //   ],
    //   content: this.modelValue,
    //   onUpdate: () => {
    //     // HTML
    //     this.$emit('update:modelValue', this.editor.getHTML())
    //   },
    // })
  },
  beforeUnmount() {
    this.editor.destroy()
  },
  data() {
    return {
      editor: new Editor({
        extensions: [
          StarterKit,
        ],
        content: this.modelValue,
        onUpdate: () => {
          // HTML
          this.$emit('update:modelValue', this.editor.getHTML())
        },
      }),
      showGeneratedCode: false,
      commands: [
        {
          icon: 'fa-solid fa-bold',
          title: 'Bold',
          action: () => this.editor.chain().focus().toggleBold().run(),
          isActive: () => this.editor.isActive('bold'),
        },
        {
          icon: 'fa-solid fa-italic',
          title: 'Italic',
          action: () => this.editor.chain().focus().toggleItalic().run(),
          isActive: () => this.editor.isActive('italic'),
        },
        {
          icon: 'fa-solid fa-strikethrough',
          title: 'Strike',
          action: () => this.editor.chain().focus().toggleStrike().run(),
          isActive: () => this.editor.isActive('strike'),
        },
        {
          icon: 'fa-solid fa-code',
          title: 'Code',
          action: () => this.editor.chain().focus().toggleCode().run(),
          isActive: () => this.editor.isActive('code'),
        },

        {
          type: 'divider',
        },
        {
          title: 'H1',
          svg: '<svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" style="width: 1.0224609375em;height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1047 1024" version="1.1"><path d="M472.296727 930.909091v-372.363636H116.363636v372.363636h-93.090909V93.090909h93.090909v372.363636h355.886546V93.090909h93.090909v837.818182z"/><path d="M874.170182 930.955636v-0.418909h-120.413091v-69.818182h120.413091v-364.171636a283.927273 283.927273 0 0 1-120.413091 67.072V483.141818a301.335273 301.335273 0 0 0 74.146909-31.278545 304.500364 304.500364 0 0 0 66.187636-52.922182h60.183273v461.730909h93.090909v69.818182h-93.090909V930.909091z"/></svg>',
          action: () => this.editor.chain().focus().toggleHeading({ level: 1 }).run(),
          isActive: () => this.editor.isActive('heading', { level: 1 }),
        },
        {
          title: 'H2',
          svg: '<svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" style="width: 1em;height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1"><path d="M662.667636 930.909091a203.776 203.776 0 0 1 52.130909-139.310546 667.787636 667.787636 0 0 1 118.225455-96.954181 547.467636 547.467636 0 0 0 74.891636-61.021091 130.653091 130.653091 0 0 0 35.979637-87.179637 86.946909 86.946909 0 0 0-24.250182-67.025454 102.4 102.4 0 0 0-71.214546-22.341818 86.853818 86.853818 0 0 0-74.938181 34.257454 163.607273 163.607273 0 0 0-27.927273 97.745455h-80.058182a206.196364 206.196364 0 0 1 50.688-143.034182 170.402909 170.402909 0 0 1 134.981818-57.344 176.267636 176.267636 0 0 1 124.136728 43.938909 150.807273 150.807273 0 0 1 47.662545 114.734545 185.530182 185.530182 0 0 1-51.2 125.952 740.864 740.864 0 0 1-108.683636 85.690182 258.513455 258.513455 0 0 0-101.329455 100.538182H1024V930.909091z m-216.482909 0v-372.363636H93.090909v372.363636H0V93.090909h93.090909v372.363636h353.047273V93.090909h93.090909v837.818182z"/></svg>',
          action: () => this.editor.chain().focus().toggleHeading({ level: 2 }).run(),
          isActive: () => this.editor.isActive('heading', { level: 2 }),
        },
        {
          icon: 'fa-solid fa-paragraph',
          title: 'Paragraph',
          action: () => this.editor.chain().focus().setParagraph().run(),
          isActive: () => this.editor.isActive('paragraph'),
        },
        {
          icon: 'fa-solid fa-list-ul',
          title: 'Bullet List',
          action: () => this.editor.chain().focus().toggleBulletList().run(),
          isActive: () => this.editor.isActive('bulletList'),
        },
        {
          icon: 'fa-solid fa-list-ol',
          title: 'Ordered List',
          action: () => this.editor.chain().focus().toggleOrderedList().run(),
          isActive: () => this.editor.isActive('orderedList'),
        },
        {
          icon: 'fa-solid fa-code',
          title: 'Code Block',
          action: () => this.editor.chain().focus().toggleCodeBlock().run(),
          isActive: () => this.editor.isActive('codeBlock'),
        },
        {
          type: 'divider',
        },
        {
          icon: 'fa-solid fa-quote-left',
          title: 'Blockquote',
          action: () => this.editor.chain().focus().toggleBlockquote().run(),
          isActive: () => this.editor.isActive('blockquote'),
        },
        {
          title: 'separator',
          svg: '<svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" style="width: 1.0224609375em;height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 10 10" version="1.1"><line x1="0" y1="5" x2="10" y2="5" stroke="currentColor"></line></svg>',
          action: () => this.editor.chain().focus().setHorizontalRule().run(),
        },
        {
          type: 'divider',
        },
        {
          icon: 'fa-solid fa-arrow-turn-down',
          title: 'Hard Break',
          action: () => this.editor.chain().focus().setHardBreak().run(),
        },
        {
          icon: 'fa-solid fa-text-slash',
          title: 'Clear Format',
          action: () => this.editor.chain()
              .focus()
              .clearNodes()
              .unsetAllMarks()
              .run(),
        },
        {
          type: 'divider',
        },
        {
          icon: 'fa-solid fa-rotate-left',
          title: 'Undo',
          action: () => this.editor.chain().focus().undo().run(),
        },
        {
          icon: 'fa-solid fa-rotate-right',
          title: 'Redo',
          action: () => this.editor.chain().focus().redo().run(),
        },
      ],
    }
  },


  watch: {
    modelValue(value) {
      // HTML
      const isSame = this.editor.getHTML() === value

      // JSON
      // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

      if (isSame) {
        return
      }

      this.editor.commands.setContent(value, false)
    },
  },
}
</script>

<style lang="scss">
.editor__content{
  padding: 0 !important;
  margin: 0 !important;
  background: var(--kt-input-bg);
  .ProseMirror{
    background: var(--kt-input-bg);
    border-radius: 10px;
    padding: 10px;
    min-height: 10rem;
    outline: 0;
    p{
      padding: 0 !important;
      margin: 0 !important;
    }
  }
}

.editor {
  background-color: #FFF;
  border: 3px solid var(--kt-input-solid-bg);
  border-radius: 0.75rem;
  color: var(--kt-input-color);
  display: flex;
  flex-direction: column;
  max-height: 26rem;

  &__header {
    align-items: center;
    background: var(--kt-input-solid-bg);
    border-bottom: 3px solid var(--kt-input-solid-bg);
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
    display: flex;
    flex: 0 0 auto;
    flex-wrap: wrap;
    padding: 0.25rem;
  }

  &__content {
    flex: 1 1 auto;
    overflow-x: hidden;
    overflow-y: auto;
    padding: 1.25rem 1rem;
    -webkit-overflow-scrolling: touch;
  }

  &__footer {
    align-items: center;
    border-top: 3px solid #0D0D0D;
    color: #0D0D0D;
    display: flex;
    flex: 0 0 auto;
    flex-wrap: wrap;
    font-size: 12px;
    font-weight: 600;
    justify-content: space-between;
    padding: 0.25rem 0.75rem;
    white-space: nowrap;
  }

  /* Some information about the status */
  &__status {
    align-items: center;
    border-radius: 5px;
    display: flex;

    &::before {
      background: rgba(#0D0D0D, 0.5);
      border-radius: 50%;
      content: ' ';
      display: inline-block;
      flex: 0 0 auto;
      height: 0.5rem;
      margin-right: 0.5rem;
      width: 0.5rem;
    }

    &--connecting::before {
      background: #616161;
    }

    &--connected::before {
      background: #B9F18D;
    }
  }

  &__name {
    button {
      background: none;
      border: none;
      border-radius: 0.4rem;
      color: #0D0D0D;
      font: inherit;
      font-size: 12px;
      font-weight: 600;
      padding: 0.25rem 0.5rem;

      &:hover {
        background-color: #0D0D0D;
        color: #FFF;
      }
    }
  }
  .menu-item {
    background: transparent;
    border: none;
    border-radius: 0.4rem;
    color: #fff;
    cursor: pointer;
    padding: 0.5rem 1rem;
    margin-right: 0.25rem;
    //height: 1.75rem;
    //width: 1.75rem;

    svg {
      fill: currentColor;
      height: 100%;
      width: 100%;
    }

    &.is-active,
    &:hover {
      background-color: var(--kt-input-bg);
      box-shadow:0px 0px 0px 1px var(--kt-input-border-color) inset;
      //border: 1px solid var(--kt-input-border-color);
    }
  }
}

/* Give a remote user a caret */
.collaboration-cursor__caret {
  border-left: 1px solid #0D0D0D;
  border-right: 1px solid #0D0D0D;
  margin-left: -1px;
  margin-right: -1px;
  pointer-events: none;
  position: relative;
  word-break: normal;
}

/* Render the username above the caret */
.collaboration-cursor__label {
  border-radius: 3px 3px 3px 0;
  color: #0D0D0D;
  font-size: 12px;
  font-style: normal;
  font-weight: 600;
  left: -1px;
  line-height: normal;
  padding: 0.1rem 0.3rem;
  position: absolute;
  top: -1.4em;
  user-select: none;
  white-space: nowrap;
}

/* Basic editor styles */
.ProseMirror {
  > * + * {
    margin-top: 0.75em;
  }

  ul,
  ol {
    padding: 0 1rem;
  }

  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    line-height: 1.1;
  }

  code {
    background-color: rgba(#616161, 0.1);
    color: #616161;
  }

  pre {
    background: #0D0D0D;
    border-radius: 0.5rem;
    color: #FFF;
    font-family: 'JetBrainsMono', monospace;
    padding: 0.75rem 1rem;

    code {
      background: none;
      color: inherit;
      font-size: 0.8rem;
      padding: 0;
    }
  }

  mark {
    background-color: #FAF594;
  }

  img {
    height: auto;
    max-width: 100%;
  }

  hr {
    margin: 1rem 0;
  }

  blockquote {
    border-left: 2px solid rgba(#0D0D0D, 0.1);
    padding-left: 1rem;
  }

  hr {
    border: none;
    border-top: 2px solid rgba(#0D0D0D, 0.1);
    margin: 2rem 0;
  }

  ul[data-type="taskList"] {
    list-style: none;
    padding: 0;

    li {
      align-items: center;
      display: flex;

      > label {
        flex: 0 0 auto;
        margin-right: 0.5rem;
        user-select: none;
      }

      > div {
        flex: 1 1 auto;
      }
    }
  }
}

</style>
