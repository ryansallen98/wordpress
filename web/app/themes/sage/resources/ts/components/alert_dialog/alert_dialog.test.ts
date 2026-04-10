import { describe, it, expect } from 'vitest';
import { alertDialog } from './alert_dialog';

describe('alertDialog', () => {
  it('starts closed by default', () => {
    const d = alertDialog();
    expect(d.open).toBe(false);
  });

  it('respects defaultOpen', () => {
    expect(alertDialog({ defaultOpen: true }).open).toBe(true);
    expect(alertDialog({ defaultOpen: false }).open).toBe(false);
  });

  it('openDialog sets open true', () => {
    const d = alertDialog();
    d.openDialog();
    expect(d.open).toBe(true);
  });

  it('closeDialog sets open false', () => {
    const d = alertDialog({ defaultOpen: true });
    d.closeDialog();
    expect(d.open).toBe(false);
  });
});
