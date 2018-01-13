<?php

namespace Bouhnosaure\DogeWallet\Constants;

class Error
{

    /*
     * General application defined errors
     *
     * See http://www.jsonrpc.org/specification#error_object
     */

    // Parse error, invalid JSON was received by the server, an error occurred on the server while parsing the JSON text
    const RPC_PARSE_ERROR = -32700;

    // Invalid Request,	the JSON sent is not a valid Request object
    const RPC_INVALID_REQUEST = -32600;

    // Method not found, the method does not exist / is not available
    const RPC_METHOD_NOT_FOUND = -32601;

    // Invalid params, invalid method parameter(s)
    const RPC_INVALID_PARAMS = -32602;

    // Internal error, internal JSON-RPC error
    const RPC_INTERNAL_ERROR = -32603;


    /*
     * General application defined errors
     */

    // std::exception thrown in command handling
    const RPC_MISC_ERROR = -1;

    // Server is in safe mode, and command is not allowed in safe mode
    const RPC_FORBIDDEN_BY_SAFE_MODE = -2;

    // Unexpected type was passed as parameter
    const RPC_TYPE_ERROR = -3;

    const RPC_INVALID_ADDRESS_OR_KEY = -5;  // Invalid address or key

    // Ran out of memory during operation
    const RPC_OUT_OF_MEMORY = -7;

    // Invalid, missing or duplicate parameter
    const RPC_INVALID_PARAMETER = -8;

    // Database error
    const RPC_DATABASE_ERROR = -20;

    // Error parsing or validating structure in raw format
    const RPC_DESERIALIZATION_ERROR = -22;


    /*
     * P2P client errors
     */

    // Dogecoin is not connected
    const RPC_CLIENT_NOT_CONNECTED = -9;

    // Still downloading initial blocks
    const RPC_CLIENT_IN_INITIAL_DOWNLOAD = -10;

    /*
     * Wallet errors
     */

    // Unspecified problem with wallet (key not found etc.)
    const RPC_WALLET_ERROR = -4;

    // Not enough funds in wallet or account
    const RPC_WALLET_INSUFFICIENT_FUNDS = -6;

    // Invalid account name
    const RPC_WALLET_INVALID_ACCOUNT_NAME = -11;

    // Keypool ran out, call keypoolrefill first
    const RPC_WALLET_KEYPOOL_RAN_OUT = -12;

    // Enter the wallet passphrase with walletpassphrase first
    const RPC_WALLET_UNLOCK_NEEDED = -13;

    // The wallet passphrase entered was incorrect
    const RPC_WALLET_PASSPHRASE_INCORRECT = -14;

    // Command given in wrong wallet encryption state (encrypting an encrypted wallet etc.)
    const RPC_WALLET_WRONG_ENC_STATE = -15;

    // Failed to encrypt the wallet
    const RPC_WALLET_ENCRYPTION_FAILED = -16;

    // Wallet is already unlocked
    const RPC_WALLET_ALREADY_UNLOCKED = -17;
}
