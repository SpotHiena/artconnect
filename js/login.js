 const canvas = document.querySelector("canvas");
    const ctx = canvas.getContext("2d");
    const inputColor = document.querySelector(".input__color");
    const tools = document.querySelectorAll(".button__tool");
    const sizeButtons = document.querySelectorAll(".button__size");
    const buttonClear = document.querySelector(".button__clear");
    const buttonUndo = document.querySelector(".button__undo");
    const buttonRedo = document.querySelector(".button__redo");
    const buttonSave = document.querySelector(".button__save");

    let brushSize = 20;
    let isPainting = false;
    let activeTool = "brush";
    let undoStack = [];
    let redoStack = [];

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    inputColor.addEventListener("change", e => ctx.fillStyle = e.target.value);

    canvas.addEventListener("mousedown", e => {
      isPainting = true;
      if (activeTool === "brush" || activeTool === "rubber") saveState();
      if (activeTool === "brush") draw(e.clientX, e.clientY);
      if (activeTool === "rubber") erase(e.clientX, e.clientY);
    });

    canvas.addEventListener("mousemove", e => {
      if (!isPainting) return;
      if (activeTool === "brush") draw(e.clientX, e.clientY);
      if (activeTool === "rubber") erase(e.clientX, e.clientY);
    });

    canvas.addEventListener("mouseup", () => isPainting = false);

    const draw = (x, y) => {
      ctx.globalCompositeOperation = "source-over";
      ctx.beginPath();
      ctx.arc(x, y, brushSize / 2, 0, 2 * Math.PI);
      ctx.fill();
    };

    const erase = (x, y) => {
      ctx.globalCompositeOperation = "destination-out";
      ctx.beginPath();
      ctx.arc(x, y, brushSize / 2, 0, 2 * Math.PI);
      ctx.fill();
    };

    const selectTool = e => {
      const btn = e.target.closest("button");
      const action = btn.getAttribute("data-action");
      if (action) {
        tools.forEach(t => t.classList.remove("active"));
        btn.classList.add("active");
        activeTool = action;
      }
    };

    const selectSize = e => {
      const btn = e.target.closest("button");
      const size = btn.getAttribute("data-size");
      sizeButtons.forEach(t => t.classList.remove("active"));
      btn.classList.add("active");
      brushSize = size;
    };

    tools.forEach(t => t.addEventListener("click", selectTool));
    sizeButtons.forEach(b => b.addEventListener("click", selectSize));

    buttonClear.addEventListener("click", () => {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      saveState();
    });

    const saveState = () => {
      undoStack.push(canvas.toDataURL());
      redoStack = [];
    };

    const restoreState = dataUrl => {
      const img = new Image();
      img.src = dataUrl;
      img.onload = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0);
      };
    };

    buttonUndo.addEventListener("click", () => {
      if (undoStack.length > 0) {
        redoStack.push(canvas.toDataURL());
        restoreState(undoStack.pop());
      }
    });

    buttonRedo.addEventListener("click", () => {
      if (redoStack.length > 0) {
        undoStack.push(canvas.toDataURL());
        restoreState(redoStack.pop());
      }
    });

    buttonSave.addEventListener("click", () => {
      const link = document.createElement("a");
      link.download = "meu_desenho.png";
      link.href = canvas.toDataURL("image/png");
      link.click();
    });

    window.addEventListener("resize", () => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    });