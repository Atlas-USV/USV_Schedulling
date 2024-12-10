import './bootstrap';
import 'flowbite';
import { Editor } from 'https://esm.sh/@tiptap/core@2.6.6';
import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2.6.6';
import HorizontalRule from 'https://esm.sh/@tiptap/extension-horizontal-rule@2.6.6';
import CodeBlock from 'https://esm.sh/@tiptap/extension-code-block@2.6.6';
import {DataTable} from "simple-datatables"
window.Editor = Editor;
window.StarterKit = StarterKit
window.HorizontalRule = HorizontalRule
window.CodeBlock = CodeBlock
window.DataTable = DataTable