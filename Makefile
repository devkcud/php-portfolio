TAILWIND_BIN := npx tailwindcss

tail:
	$(TAILWIND_BIN) -i css/input.css -o css/output.css --watch -m

.PHONY: tail