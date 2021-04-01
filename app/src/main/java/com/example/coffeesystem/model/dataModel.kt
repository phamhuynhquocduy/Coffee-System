package com.example.coffeesystem.model

data class Product (
    val id : Int,
    val name: String,
    val image : String,
    val description: String,
    val price: Double,
    val idcategory : Int
)