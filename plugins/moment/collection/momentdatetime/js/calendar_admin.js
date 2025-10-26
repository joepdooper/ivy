class Calendar {
    constructor(root) {
        this.root = root;
        this.current = new Date();

        const yyyy = this.current.getFullYear();
        const mm = this.current.getMonth() + 1; // 1-based
        const dd = this.current.getDate();
        this.start = `${yyyy}-${String(mm).padStart(2, "0")}-${String(dd).padStart(2, "0")}`;
        this.end = null;

        this.grid = root.querySelector("[data-calendar='grid']");

        this.templates = {};
        this.grid.querySelectorAll("[data-template]").forEach(tpl => {
            this.templates[tpl.dataset.template] = tpl.cloneNode(true);
            tpl.remove();
        });

        this.monthSelect = root.querySelector("[data-calendar='monthSelect']");
        this.yearSelect = root.querySelector("[data-calendar='yearSelect']");
        this.prevBtn = root.querySelector("[data-calendar='prev']");
        this.nextBtn = root.querySelector("[data-calendar='next']");

        this.id = root.dataset.calendarId || "default";

        this.initEvents();

        const startInput = document.querySelector(`[data-calendar='start'][data-calendar-id='${this.id}']`);
        if (startInput) startInput.value = this.start;
        const endInput = document.querySelector(`[data-calendar='end'][data-calendar-id='${this.id}']`);
        if (endInput) endInput.value = "";

        this.render();
    }

    initEvents() {
        const bind = (el, fn) => el?.addEventListener("click", fn);

        bind(this.prevBtn, () => this.changeMonth(-1));
        bind(this.nextBtn, () => this.changeMonth(1));

        this.monthSelect?.addEventListener("change", e => {
            this.current.setMonth(parseInt(e.target.value, 10) - 1);
            this.render();
        });

        this.yearSelect?.addEventListener("change", e => {
            this.current.setFullYear(parseInt(e.target.value, 10));
            this.render();
        });
    }

    changeMonth(offset) {
        this.current.setMonth(this.current.getMonth() + offset);
        this.render();
    }

    render() {
        if (!this.grid) return;

        this.grid.innerHTML = "";

        const year = this.current.getFullYear();
        const month = this.current.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        if (this.monthSelect) this.monthSelect.value = month + 1;
        if (this.yearSelect) this.yearSelect.value = year;

        const fragment = document.createDocumentFragment();
        const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;

        const startDate = this.start ? new Date(this.start) : null;
        const endDate = this.end ? new Date(this.end) : null;

        for (let i = 0; i < totalCells; i++) {
            let cell;
            if (i < firstDay || i >= firstDay + daysInMonth) {
                cell = this.templates.empty.cloneNode(true);
            } else {
                const day = i - firstDay + 1;
                const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
                cell = this.getTemplateForDate(dateStr, startDate, endDate).cloneNode(true);
                cell.textContent = day;
                cell.dataset.date = dateStr;
                cell.addEventListener("click", () => this.selectDate(dateStr));
            }
            cell.classList.remove("hidden");
            fragment.appendChild(cell);
        }

        this.grid.appendChild(fragment);
    }

    getTemplateForDate(dateStr, startDate, endDate) {
        const date = new Date(dateStr);

        if (dateStr === this.start) return this.templates.start;
        if (dateStr === this.end) return this.templates.end;

        if (startDate && endDate && date > startDate && date < endDate) {
            return this.templates.inside;
        }

        return this.templates.day;
    }

    selectDate(dateStr) {
        const date = new Date(dateStr);

        if (!this.start || this.start && this.end) {
            this.start = dateStr;
            this.end = null;
        } else {
            if (date >= new Date(this.start)) this.end = dateStr;
            else { this.end = this.start; this.start = dateStr; }
        }

        const startInput = document.querySelector(`[data-calendar='start'][data-calendar-id='${this.id}']`);
        const endInput = document.querySelector(`[data-calendar='end'][data-calendar-id='${this.id}']`);

        if (startInput) startInput.value = this.start ?? "";
        if (endInput) endInput.value = this.end ?? "";

        this.render();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".calendar").forEach(el => new Calendar(el));
});