export interface AlertDialogProps {
  defaultOpen?: boolean;
}

export interface AlertDialogState {
  open: boolean;
  openDialog(): void;
  closeDialog(): void;
}

export function alertDialog({ defaultOpen = false }: AlertDialogProps = {}): AlertDialogState {
  return {
    open: defaultOpen,

    openDialog() {
      this.open = true;
    },

    closeDialog() {
      this.open = false;
    },
  };
}
