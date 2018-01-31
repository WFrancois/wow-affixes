// Type definitions for webpack-chunk-hash 0.4.0
// Project: https://github.com/alexindigo/webpack-chunk-hash
// Definitions by: Cristian Lorenzo <https://github.com/dogmatico>

import { Plugin } from "webpack";

declare class WebpackChunkHash extends Plugin {
  constructor(options?: WebpackChunkHash.WebpackChunkHashPluginOptions);
}

export = WebpackChunkHash;

declare namespace WebpackChunkHash {
  interface WebpackChunkHashPluginOptions {
    /**
     * A callback to add more content to the resulting hash
     */
    additionalHashContent?: (chunk: any) => string;
    /**
     * Which algorithm to use. Defaults to 'md5'.
     * See https://nodejs.org/api/crypto.html#crypto_crypto_createhash_algorithm
     */
    algorithm?: string;
    /**
     * Which digest to use. Defaults to 'hex'.
     * See https://nodejs.org/api/crypto.html#crypto_hash_digest_encoding
     */
    digest?: "hex" | "latin1" | "base64";
  }
}
