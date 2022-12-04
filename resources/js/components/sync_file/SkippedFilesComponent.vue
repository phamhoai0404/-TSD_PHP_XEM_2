<template>
    <v-dialog
            v-model="isOpen"
            max-width="600"
    >
        <v-card id="confirm">
            <v-card-title class="headline">{{ $t('message.alert.confirm') }}</v-card-title>
            <v-card-text>
                {{ $t('message.sync_file.skipped_files') }}
                <slot></slot>
            </v-card-text>
            <v-card-actions>
                <v-btn color="orange darken-1" flat="flat" @click="$emit('close')">
                    {{ $t('message.alert.acknowledge') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default{
        name: 'SkippedFiles',
        data() {
            return {
                isOpen: true
            }
        },
        watch: {
            isOpen() {
                this.$emit('close');
            }
        }
    }
</script>
<style >
</style>