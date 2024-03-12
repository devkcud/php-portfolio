TAILWIND_BIN := tailwindcss

tail:
	$(TAILWIND_BIN) -i css/input.css -o css/output.css --watch

.PHONY: tail