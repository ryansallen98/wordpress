import { describe, it, expect, vi } from 'vitest';
import { accordion } from './accordion';

function mockTrigger(): HTMLElement {
  return { focus: vi.fn() } as unknown as HTMLElement;
}

describe('accordion', () => {
  describe('single', () => {
    it('starts with no panel open', () => {
      const a = accordion({ type: 'single' });
      expect(a.open).toBeNull();
      expect(a.isOpen('x')).toBe(false);
    });

    it('toggle opens and closes the same id', () => {
      const a = accordion({ type: 'single' });
      a.toggle(1);
      expect(a.isOpen(1)).toBe(true);
      a.toggle(1);
      expect(a.isOpen(1)).toBe(false);
      expect(a.open).toBeNull();
    });

    it('opening another id closes the previous', () => {
      const a = accordion({ type: 'single' });
      a.toggle('a');
      expect(a.open).toBe('a');
      a.toggle('b');
      expect(a.open).toBe('b');
      expect(a.isOpen('a')).toBe(false);
    });
  });

  describe('multiple', () => {
    it('starts with empty open list', () => {
      const a = accordion({ type: 'multiple' });
      expect(a.open).toEqual([]);
      expect(a.isOpen(1)).toBe(false);
    });

    it('toggle adds and removes ids', () => {
      const a = accordion({ type: 'multiple' });
      a.toggle(1);
      a.toggle(2);
      expect(a.isOpen(1)).toBe(true);
      expect(a.isOpen(2)).toBe(true);
      a.toggle(1);
      expect(a.isOpen(1)).toBe(false);
      expect(a.isOpen(2)).toBe(true);
    });
  });

  describe('registerTrigger', () => {
    it('dedupes the same element', () => {
      const a = accordion({ type: 'single' });
      const el = mockTrigger();
      a.registerTrigger(el);
      a.registerTrigger(el);
      expect(a.focusList.length).toBe(1);
    });
  });

  describe('moveFocus', () => {
    it('wraps forward and backward in focusList order', () => {
      const a = accordion({ type: 'single' });
      const b1 = mockTrigger();
      const b2 = mockTrigger();
      const b3 = mockTrigger();
      a.registerTrigger(b1);
      a.registerTrigger(b2);
      a.registerTrigger(b3);

      a.moveFocus(1, b1);
      expect(b2.focus).toHaveBeenCalledTimes(1);

      a.moveFocus(1, b3);
      expect(b1.focus).toHaveBeenCalledTimes(1);

      a.moveFocus(-1, b1);
      expect(b3.focus).toHaveBeenCalledTimes(1);
    });

    it('no-ops when current is not in the list', () => {
      const a = accordion({ type: 'single' });
      const b1 = mockTrigger();
      a.registerTrigger(b1);
      const orphan = mockTrigger();
      a.moveFocus(1, orphan);
      expect(b1.focus).not.toHaveBeenCalled();
      expect(orphan.focus).not.toHaveBeenCalled();
    });
  });
});
