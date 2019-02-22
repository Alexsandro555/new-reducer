<template>
    <div id="baskets">
        <modal-window v-if="modal" @close="closeModal" :width="800">
            <div class="callback_close" @click="closeModal"></div>
            <table width="100%" class="cart-table">
                <thead class="cart-header">
                    <tr>
                        <th class="center" colspan="6">
                            Корзина товаров
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Наименование товара</th>
                        <th>Количество</th>
                        <th>Стоимость</th>
                        <th>Артикул</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody cellpadding="0" cellspacing="0">
                    <cart-item v-for="cartItem in cart" :key="cartItem.rowId" :cart-item="cartItem"></cart-item>
                </tbody>
                <tfoot>
                <tr valign="middle">
                    <td colspan="1"></td>
                    <td colspan="3" align="right">
                        Общая стоимость с НДС 20%:
                    </td>
                    <td colspan="2" align="center">{{totalCart}}₽</td>
                </tr>
                </tfoot>
            </table>
            <br>
            <center>
                <a href="/order" class="cart-submit">Оформить</a>
            </center>
            <br>
        </modal-window>
    </div>
</template>
<script>
    import { mapGetters, mapActions, mapState, mapMutations } from 'vuex'
    import { GETTERS, ACTIONS, MUTATIONS } from "@cart/constants"
    import ModalWindow from "./ModalWindow"
    import CartItem from "./CartItem"

    export default {
        props: { },
        data: function() {
            return {
            }
        },
        mounted() {
            this.load()
        },
        computed: {
            ...mapState('cart', ['cart', 'modal']),
            ...mapGetters('cart', {totalCart: GETTERS.TOTAL_CART, QtyCart: GETTERS.QTY_CART}),
        },
        components: {
            ModalWindow,
            CartItem
        },
        methods: {
            closeModal() {
                this.close();
            },
            ...mapActions('cart',{ load: ACTIONS.LOAD }),
            ...mapMutations('cart',{ close: MUTATIONS.CLOSE_CART_MODAL })
        }
     }
</script>

<style>
    #baskets .cart-col
    {
        margin-left:0px;
    }
    #baskets .div-plus,#baskets .div-minus
    {
        right:6px;
    }
    #baskets table thead
    {
        border-radius: 12px;

    }
    #baskets table thead,form div.content-right-order table thead
    {
        background-color:#333333;
        color:white;
    }
    #baskets table thead tr
    {
        line-height: 45px;
        height:45px;
        padding: 0;
    }
    #baskets table tbody tr
    {
        border-bottom:1px solid #eee;
        vertical-align:middle;
    }
    #baskets table tbody tr td
    {
        position: relative;
        text-align: center;
        border: 0px;
    }
    #baskets table tbody tr td:nth-child(2)
    {
        text-align: left;
    }
    #baskets table tbody tr td:nth-child(2) span,form div.content-right-order table tbody tr td:nth-child(2) span
    {
        color:#aaa;
        font-size:9pt;
    }
    #baskets table tbody tr td:nth-child(6) img
    {
        cursor:hand;
        cursor:pointer;
    }
    #baskets table tfoot tr,form div.content-right-order table tfoot tr {
        background-color:#333333;
        line-height:45px;
        height:45px;
    }
    #baskets table tfoot tr td,form div.content-right-order table tfoot tr td {
        font-weight: bold;
        font-size:13pt;
        color:white;
    }
    .callback_close {
        background: rgba(0, 0, 0, 0) url('/images/close.png') no-repeat scroll 0 0;
        cursor: pointer;
        height: 22px;
        position: absolute;
        right: -34px;
        top: 5px;
        width: 22px;
        z-index: 2147483647;
    }
    .cart-submit{
        background-color: #333333;
        border: 2px solid #333333;
        border-radius: 2px;
        color: #ffffff;
        font-weight: 600;
        height: 35px;
        width: 125px;
        padding: 10px;
    }
    .cart-header {
        background-color: #28435c;
        color: black;
    }
    .cart-table {
        border-collapse: collapse;
        border-spacing: 0;
    }
</style>