<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { toast } from 'vue-sonner';

defineProps<{
    dialog: string;
    title: string;
    description: string;
    info: string;
    event: () => void;
}>();
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button>{{ dialog }}</Button>
        </DialogTrigger>
        <DialogContent
            class="sm:max-w-md"
            @interact-outside="
                (event) => {
                    const target = event.target as HTMLElement;
                    if (target?.closest('[data-sonner-toaster]')) return event.preventDefault();
                }
            "
        >
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
                <DialogDescription>
                    {{ description }}
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button variant="secondary">Batal</Button>
                <Button
                    @click="
                        () => {
                            event();
                            toast.success(info);
                        }
                    "
                    >Kirim</Button
                >
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
