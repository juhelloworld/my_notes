function confirmAction(note_id) {
    if (confirm("Are you sure you want to delete?")) {
        deleteNote(note_id);
    } else {
        alert("Delete action was canceled.");
    }
};

function deleteNote(idNote) {
    
      fetch("delete_note.php?note_id=" + idNote)
          .then((res) => res.json())
          .then((data) => {
              window.location.reload();
          })
          .catch((error) => {
              console.error("Error deleting notes:", error);
          });

}

function confirmActionAll() {
    if (confirm("Are you sure you want to delete all notes?")) {
        deleteAllNotes();
    } else {
        alert("Delete action was canceled.");
    }
};

function deleteAllNotes() {

    fetch("delete_note.php?note_id=0")
        .then((res) => res.json())
        .then((data) => {
            window.location.reload();
        })
        .catch((error) => {
            console.error("Error deleting notes:", error);
        });
}

