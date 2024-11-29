const LiEditorMainTitle = function(ListOfFields){
    const MainTitle = document.createElement('div');
    MainTitle.classList.add('lieditor-field');
    MainTitle.innerHTML = `<input type="text" placeholder="Write a title" class="lieditor-input-text-h1" name="title">`;
    const PhysicalField = MainTitle.querySelector('input');
    ListOfFields.push(PhysicalField);
    PhysicalField.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            ListOfFields[1].focus();
        }
    });
    return MainTitle;
};

const LiEditorTextarea = function(ListOfFields){
    const PhysicalField = document.createElement('textarea');
    PhysicalField.name = `text_${ListOfFields.length}`;
    PhysicalField.classList.add('lieditor-text-large');
    PhysicalField.setAttribute('placeholder', 'Start writing text...');
    PhysicalField.addEventListener('input', function(){
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    PhysicalField.addEventListener("keypress", function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const NewPhysicalField = LiEditorTextarea(ListOfFields);
            this.parentNode.insertBefore(NewPhysicalField, this.nextSibling);
            NewPhysicalField.focus();
        }
    });
    PhysicalField.addEventListener('keydown', (event) => {
        if ((event.ctrlKey || event.metaKey) && event.key === 'Delete') {
            PhysicalField.remove();
        }

        if ((event.ctrlKey || event.metaKey) && event.key === 'ArrowUp') {
            const previousNode = PhysicalField.previousElementSibling;
            if (PhysicalField && previousNode && PhysicalField.parentElement === previousNode.parentElement) {
                PhysicalField.parentElement.insertBefore(PhysicalField, previousNode);
                PhysicalField.focus();
            }
        }

        if ((event.ctrlKey || event.metaKey) && event.key === 'ArrowDown') {
            const nextNode = PhysicalField.nextElementSibling;
            if (PhysicalField && nextNode && PhysicalField.parentElement === nextNode.parentElement) {
                PhysicalField.parentElement.insertBefore(nextNode, PhysicalField);
                PhysicalField.focus();
            }
        }
    });
    ListOfFields.push(PhysicalField);
    return PhysicalField;
};
const LiEditorTextBlock = function(ListOfFields){
    const LiBlock = document.createElement('div');
    LiBlock.classList.add('lieditor-field');
    const PhysicalField = LiEditorTextarea(ListOfFields);
    LiBlock.appendChild(PhysicalField);
    return LiBlock;
};

const LiEditorSubmitter = function(){
    const Submitter = document.createElement('div');
    Submitter.classList.add('lieditor-field');
    Submitter.innerHTML = `<input name="lisubmitter" type="submit" class="lieditor-button-subbmit" value="Process">`;
    return Submitter;
};

const LiEditorProcess = function({event, outPut, editor}) {
    event.preventDefault();
    const formData = new FormData(editor, editor.lisubmitter);
    for (const [key, value] of formData) {
        if( "lisubmitter" != key ) {
            outPut.innerHTML += `${key}: ${value}\n`;
        }
    }
};

document.addEventListener('DOMContentLoaded', function(){
    const LiEditorOutPut = document.querySelector('#lieditor-output');
    const LiEditorContainer = document.querySelector('.lieditor-container');
    const LieditorSubmitterButton = LiEditorSubmitter();
    const LieditorFields = [];
    LiEditorContainer.addEventListener('submit', function(e){
        LiEditorProcess({
            event: e,
            outPut: LiEditorOutPut, 
            editor: LiEditorContainer
        });
    });
    LiEditorContainer.appendChild(LiEditorMainTitle(LieditorFields));
    LiEditorContainer.appendChild(LiEditorTextBlock(LieditorFields));
    LiEditorContainer.appendChild(LieditorSubmitterButton);
});