<template>
    <v-dialog v-model="isOpen" max-width="480">
        <v-card id="confirm">
            <v-card-text>
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
        name: 'ChangeFileResult',
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